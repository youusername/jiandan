<html>
<head>
<meta charset="UTF-8">
<title>测试提交</title>
</head>
<body>
<form action="<?php echo $PATH_INFO ?>" method=post>
<div align=center><input type="submit" value="up"><input type="submit" value="down"></div>
</form>
</body>
</html>
<?php
require_once 'simple_html_dom.php';
ini_set("display_errors","true");
class jiandan
{
    public $BASE_URL;
    public $previousUrl;
    public $upUrl;
    public function __construct()
    {
        $this->BASE_URL = "http://jandan.net/pic";
    }
    
    public function isEqualToImage($imageStr){
        
        if (strlen($imageStr)>60) {
            if (strpos($imageStr, 'thumb180') == false) {
                return $imageStr;
            }
        }
        
    }
    public function loadJiandan()
    {
        $images = [];

        $source = file_get_contents($this->BASE_URL);

        $html = str_get_html($source);
        $div = $html->find('img[src=*]');
        //获取上一页的URL
        $previous = $html->find('a[class=previous-comment-page]');

        $this->previousUrl = $previous[0]->href;
        //获取下一页的URL
        $net = $html->find('a[class=next-comment-page]');
        if ($net->href) {
            $this->upUrl = $net[0]->href;
        }else{
            $this->upUrl = "http://jandan.net/pic";
        }
        
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

if($submit){
    if ($up) {
        echo "-----------";
        // $this->BASE_URL = $this->upUrl;
        // echo "<script>location:reload();</script>";
    }
    if ($down) {
        // $this->BASE_URL = $this->previousUrl;
        // echo "location:reload();";
        echo "==========";
    }
}
// echo "<div align=center><input type=\"submit\" value=\"上一页\" name=\"up\"><input type=\"submit\" value=\"下一页\" name=\"down\"></div>";
foreach ($b8->loadJiandan() as $key) {
    echo "<div align=center><img src=\"$key\"></div>";
}
echo "<input type=\"submit\" value=\"up\"><input type=\"submit\" value=\"down\">";


?>
