<?= '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<?
function xml_entities($string) {
    return str_replace(
        array("&", "<", ">"),
        array("&amp;", "&lt;", "&gt;"),
        $string
    );
}
?>
<Response>
    <?
    $json = json_decode(urldecode($_GET['json']), true);
    foreach($json as $item){
        if(isset($item['Say'])){
            echo '<Say>' . xml_entities($item['Say']) . '</Say>';
        } else if(isset($item['Pause'])) {
            echo '<Pause length="' . xml_entities($item['Pause']) . '"></Pause>';
        }
    }
    ?>
</Response>