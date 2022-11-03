<?php

namespace Hyvor\Laradocs;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use ParsedownExtra;

class ContentProcessor
{
    private array $config;
    private array $data;
    public function __construct()
    {
        $this->config = config('laradocs_config') ?? [];
        $this->data = [];
    }

    public function process(string $route, string $page) : mixed
    {
        $key = array_search($route, array_column($this->config, 'route'));
        $documentConfig = $this->config[$key];
        $contentDir = $documentConfig['content_directory'] ?? 'docs';
        $navigation = $documentConfig['navigation'] ?? [];

        $linkData = $this->getLinkData($navigation, $page);
        $filePath = $linkData->getData()->file;
        $title = $linkData->getData()->label;

        $cacheKey = $route.'|'.$filePath;
        if(Cache::store('file')->get($cacheKey))
            return Cache::store('file')->get($cacheKey);
        else{
            $file = (string) resource_path("views/$contentDir/$filePath.md");
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

            return view('laradocs_views::docs', [
                'pageName' => $page,
                'content' => $content,
                'title' => $title,
                'route' => $route,
                'theme' => $documentConfig['theme'] ?? 'theme',
                'nav' => $navigation,
            ]);
        }
    }

     /**
     * Return a new JSON response from the application.
     *
     * @param  array<array> $navigation
     * @param  string  $page
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

    private function replaceDynamicData(string $markdown) : string
    {
        foreach ($this->data as $key => $value) {
            $markdown = str_replace('{{'.$key.'}}', $value, $markdown);
        }

        return $markdown;
    }

    public function setData(array $data) : void
    {
        $this->data = $data;
    }
}