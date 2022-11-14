<?php

namespace Hyvor\Laradocs;

use Illuminate\Http\JsonResponse;
use ParsedownExtra;

class ContentProcessor
{
    private array $config;
    private array $data;
    public function __construct()
    {
        $this->config = (array) config('laradocs');
        $this->data = [];
    }

    public function process(string $route, string $page) : JsonResponse
    {
        $config = $this->getConfig($route);
        $contentDir = $config['content_directory'] ?? 'docs';
        $navigation = $config['navigation'] ?? [];

        $linkData = $this->getLinkData($navigation, $page);
        $filePath = $linkData->getData()->file;
        $label = $linkData->getData()->label;

        $file = base_path("$contentDir/$filePath.md");
        if (file_exists($file)) {
            $content = file_get_contents($file);
            if (!$content)
                return abort(404);

            $parseDown = new ParsedownExtra();
            $content = $parseDown->text($content);
            $content = $this->replaceDynamicData($content);
        } else {
            $error = "Content file does not exist or empty";
            $content = "<div class='error-message'>$error</div>";
        }

        return response()->json([
            'pageName' => $page,
            'content' => $content,
            'label' => $label,
            'route' => $route,
            'nav' => $navigation,
        ]);
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
     * @return array<mixed>
     **/
    public function getConfig(string $route) : array
    {
       $key = array_search($route, array_column($this->config, 'route'));
       return $this->config[$key];
    }

     /**
     * Return a new JSON response from the application.
     *
     * @param array{ section: array{ link: array{ id: string, file?: string, label: string } } } $navigation
     * @param string  $page
     * @return \Illuminate\Http\JsonResponse
     */
    private function getLinkData(array $navigation, string $page) : JsonResponse 
    {
        foreach($navigation as $section){
            foreach($section as $link){
                if($link['id'] == $page){
                    if(isset($link['file']))
                        return new JsonResponse(['label' => $link['label'], 'file' => $link['file']]);
                    else
                        return new JsonResponse(['label' => $link['label'], 'file' => !empty($link['id']) ? $link['id'] : 'index']);
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

    public function setData(array $data) : void
    {
        $this->data = $data;
    }
}