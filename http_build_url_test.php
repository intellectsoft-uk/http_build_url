<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Testing http_build_url()</title>

    <style type="text/css">

    body {
        background-color: #fff;
        margin: 40px;
        font: 13px/20px normal Helvetica, Arial, sans-serif;
        color: #4F5155;
    }

    h1 {
        color: #444;
        font-size: 24px;
        margin: 0 0 14px 0;
        padding: 14px 15px 10px 15px;
    }

    code {
        font-family: Consolas, Monaco, Courier New, Courier, monospace;
        font-size: 16px;
        border: 1px solid #D0D0D0;
        color: #002166;
        display: block;
        margin: 14px 0 14px 0;
        padding: 12px 10px 12px 10px;
    }

    </style>
</head>
<body>

    <h1>Testing http_build_url()</h1>

<?php

require dirname(__FILE__).'/http_build_url.php';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 0
echo http_build_url();
// Expected result: The URL of the current page being accessed, without the query string.
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 1
// From http://php.net/manual/en/function.http-build-url.php
echo http_build_url('http://user@www.example.com/pub/index.php?a=b#files',
    array(
        'scheme' => 'ftp',
        'host' => 'ftp.example.com',
        'path' => 'files/current/',
        'query' => 'a=c'
    ),
    HTTP_URL_STRIP_AUTH | HTTP_URL_JOIN_PATH | HTTP_URL_JOIN_QUERY | HTTP_URL_STRIP_FRAGMENT
);
// Expected result:
// ftp://ftp.example.com/pub/files/current/?a=c
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 2
echo http_build_url('http://mike@www.example.com/foo/bar', './baz', HTTP_URL_STRIP_AUTH|HTTP_URL_JOIN_PATH);
// Expected result:
// http://www.example.com/foo/baz
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 3
echo http_build_url('http://mike@www.example.com/foo/bar/', '../baz', HTTP_URL_STRIP_USER|HTTP_URL_JOIN_PATH);
// Expected result:
// http://www.example.com/foo/baz
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 4
echo http_build_url('http://mike:1234@www.example.com/foo/bar/', './../baz', HTTP_URL_STRIP_PASS|HTTP_URL_JOIN_PATH);
// Expected result:
// http://mike@www.example.com/foo/baz
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 5
echo http_build_url('http://www.example.com:8080/foo?a[0]=b#frag', '?a[0]=1&b=c&a[1]=b', HTTP_URL_JOIN_QUERY|HTTP_URL_STRIP_PORT|HTTP_URL_STRIP_FRAGMENT|HTTP_URL_STRIP_PATH);
// Expected result:
// http://www.example.com/?a%5B0%5D=1&a%5B1%5D=b&b=c
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 6
echo http_build_url('/path/?query#anchor');
// Expected similar result:
// http://localhost/path/?query#anchor
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 7
echo http_build_url('/path/?query#anchor', array('scheme' => 'https'));
// Expected similar result:
// https://localhost/path/?query#anchor
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 8
echo http_build_url('/path/?query#anchor', array('scheme' => 'https', 'host' => 'ssl.example.com'));
// Expected result:
// https://ssl.example.com/path/?query#anchor
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 9
echo http_build_url('/path/?query#anchor', array('scheme' => 'ftp', 'host' => 'ftp.example.com', 'port' => 21));
// Expected result:
// ftp://ftp.example.com/path/?query#anchor
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 10
echo http_build_url(parse_url('http://example.org/orig?q=1#f'), parse_url('https://www.example.com:9999/replaced#n'));
// Expected result:
// https://www.example.com:9999/replaced?q=1#n
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 11
echo http_build_url(('http://example.org/orig?q=1#f'), ('https://www.example.com:9999/replaced#n'), 0, \$u);
echo '<br />';
echo nl2br(str_replace(' ', '&nbsp;', print_r(\$u, true)));
// Expected results:
// https://www.example.com:9999/replaced?q=1#n
// Array
// (
//     [scheme] => https
//     [host] => www.example.com
//     [port] => 9999
//     [path] => /replaced
//     [query] => q=1
//     [fragment] => n
// )
EOT;

highlight_string($code);

echo '<code>';
echo 'Results:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 12
echo http_build_url('page');
// Expected similar result:
// http://localhost/page
// or
// http://localhost/my-path/page
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 13
echo http_build_url('with/some/path/');
// Expected similar result:
// http://localhost/with/some/path/
// or
// http://localhost/my-path/with/some/path/
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 14
echo http_build_url('http://www.example.com/path/to/page/', '../../../another/location', HTTP_URL_JOIN_PATH);
// Expected result:
// http://www.example.com/another/location
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 15
echo http_build_url('http://www.example.com/path/to/page/', '../../../another/location/', HTTP_URL_JOIN_PATH);
// Expected result:
// http://www.example.com/another/location/
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 16
echo http_build_url('http://www.example.com/another/location', '../../path/to/page', HTTP_URL_JOIN_PATH);
// Expected result:
// http://www.example.com/path/to/page
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 17
echo http_build_url('http://www.example.com/path/to/page/', '../another/location/', HTTP_URL_JOIN_PATH);
// Expected result:
http://www.example.com/path/to/another/location/
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 18
echo http_build_url('http://www.example.com/path/to/page/', './another/subpage/', HTTP_URL_JOIN_PATH);
// Expected result:
// http://www.example.com/path/to/page/another/subpage/
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 19
echo http_build_url('http://www.example.com/path/to/page/', '/another/location', HTTP_URL_JOIN_PATH);
// Expected result:
// http://www.example.com/another/location
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

$code = <<<EOT
// Test 20
echo http_build_url('http://www.example.com/path/to/page/../../../another/location/', null, HTTP_URL_JOIN_PATH);
// Expected result:
// http://www.example.com/another/location/
EOT;

highlight_string($code);

echo '<code>';
echo 'Result:<br />';
eval($code);
echo '</code>';

//------------------------------------------------------------------------------

?>

</body>
</html>