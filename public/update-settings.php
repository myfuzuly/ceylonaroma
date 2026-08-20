<?php
$pdo = new PDO('mysql:host=127.0.0.1;dbname=procare_cearoma;charset=utf8mb4','procare_aroma','6ekz5NDJwXoc',[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
$rows = $pdo->query("SELECT `key`,`value` FROM settings WHERE `key` LIKE 'stat%'")->fetchAll(PDO::FETCH_ASSOC);
echo "Before:<br>";
foreach($rows as $r) echo $r['key'].' = '.$r['value'].'<br>';
$updates=['stat_countries'=>'60+','stat_products'=>'500+','stat_years'=>'15+'];
foreach($updates as $k=>$v){
    $n=$pdo->prepare("UPDATE settings SET value=?,updated_at=NOW() WHERE `key`=?");
    $n->execute([$v,$k]);
    echo "Updated $k -> $v (".$n->rowCount()." row)<br>";
}
echo "Done.";
