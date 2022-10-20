<!DOCTYPE html>
<html>
<head>
    @include('docgenviews::meta', [
        'title' => 'Hyvor Blogs - A simple and powerful blogging platform',
        'description' => 'Hyvor Blogs is a simple and powerful blogging platform with a rich text editor, multi language support, APIs and webhooks, etc.',
        'image' => 'https://blogs.hyvor.com/img/banner.png',
        'canonical' => 'https://blogs.hyvor.com',
    ])
</head>

<body class="index">
@include('docgenviews::nav')
<div class="button-main">
    <a data-flashload-skip-link href="/console?signup=1" class="button big">
        Start a Blog
    </a>
</div>
@include('docgenviews::footer')


{{-- <script async src="/js-static/gsap.min.js" onload="setUpGsap()"></script> --}}

</body>
</html>