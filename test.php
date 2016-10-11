<?php
require_once 'simple_html_dom.php';
ini_set("display_errors","true");
class jiandan
{
    public $BASE_URL;
    public function __construct()
    {
        $this->BASE_URL = "http://jandan.net/pic/page-";
    }
    public function isEqualToImage($imageStr){
        
        if (strlen($imageStr)>60) {
            if (strpos($imageStr, 'thumb180') == false) {
                return $imageStr;
            }
        }
        
    }
    public function loadJiandan($page, $type = 0)
    {
        $images = [];
        $val = $page.'#comments';

        $url = $this->BASE_URL.$val;
        // echo $url."\n";
        $source = file_get_contents($url);

        $html = str_get_html($source);
        $div = $html->find('img[src=*]');
        foreach ($div as $key) {
            $image = $this->isEqualToImage($key->src);
            $imageto = $this->isEqualToImage($key->org_src);
            if ($image) {
                $images[] = $image;
            }
            if ($imageto) {
                $images[] = $imageto;
            }
        }
        // var_dump($images);
        return $images;
    }
}

$b8 = new jiandan();
// var_dump($b8->loadMovies(2048));
echo "<input type=\"submit\" value=\"up\"><input type=\"submit\" value=\"down\">";
foreach ($b8->loadJiandan(2048) as $key) {
    echo "<div align=center><img src=\"$key\"></div>";
}
echo "<input type=\"submit\" value=\"up\"><input type=\"submit\" value=\"down\">";
?>