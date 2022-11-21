<?php

namespace Hyvor\Laradocs;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use ParsedownExtra;

/**
 * @phpstan-type NavigationObject array{ array{ array{ id: string, file?: string, label: string } } }
 * @phpstan-type ConfigObject array{ route: string, view: string, content_directory: string, navigation : NavigationObject }
 */
class ContentProcessor
{
    /**
     * @var array< ConfigObject >
     */
    private array $config;
    /**
     * @var array< string, string>
     */
    private array $data;
    
    public function __construct()
    {
        $this->config = (array) config('laradocs');/** @phpstan-ignore-line */
        $this->data = [];
    }

    public function process(string $route, string $page) : JsonResponse
    {
        $config = $this->getConfig($route);
        $contentDir = strval($config['content_directory']);
        $navigation = $config['navigation'];

        $linkData = $this->getLinkData($navigation, $page);
        $filePath = $linkData['file'];
        $title = $linkData['label'];

        $file = $this->getContentPath($contentDir, $filePath);
        if (file_exists($file)) {
            $content = file_get_contents($file);
            if (!$content)
                return abort(404);

            $parseDown = new ParsedownExtra();
            $content = $parseDown->text($content);
            $content = $this->replaceDynamicData($content);
        } else {
            $content = "<div class='error-message'>Content file does not exist or empty</div>";
            return abort(404);
        }

        return Response::json([
            'pageName' => $page,
            'content' => $content,
            'title' => $title,
            'route' => $route,
            'nav' => $navigation,
        ]);
    }

    protected function getContentPath(string $dir, string $fileName) : string 
    {
        if(env('APP_ENV') == 'testing')
            return "__DIR__/../$dir/$fileName.md";
        else
            return base_path("$dir/$fileName.md");
    }

    public function cacheViews(string $route, string $page) : mixed
    {
        $data = $this->process($route, $page);

        $content = (array) json_decode($data->content(), true);
        return view('laradocs::docs', 
            $content
        );
    }

    /**
     * @return ConfigObject
     **/
    public function getConfig(string $route) : array
    {
       $key = array_search($route, array_column($this->config, 'route'));
       return $this->config[$key];
    }

     /**
     * Return a new JSON response from the application.
     *
     * @param NavigationObject $navigation
     * @param string  $page
     * @return array< string, string>
     */
    private function getLinkData(array $navigation, string $page) : array 
    {
        foreach($navigation as $section){
            foreach($section as $link){
                if($link['id'] == $page){
                    if(isset($link['file']))
                        return ['label' => $link['label'], 'file' => $link['file']];
                    else
                        return ['label' => $link['label'], 'file' => !empty($link['id']) ? $link['id'] : 'index'];
                }
            }
        }

        return abort(404);
    }

    public function replaceDynamicData(string $markdown) : string
    {
        foreach ($this->data as $key => $value) {
            $markdown = preg_replace("/{{(\s*($key+)\s*)}}/", $value, $markdown ?? '');
        }

        return $markdown ?? '';
    }

    /**
    * @param array{ key : string, value : string } $data
    **/
    public function setData(array $data) : void
    {
        $this->data = $data;
    }
}