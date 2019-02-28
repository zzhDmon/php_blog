<?php 
require './lib/init.php';

$sql="select comment.*,title from comment left join art on comment.art_id=art.art_id";
$comms = mGetAll($sql);

require PATH.'/view/admin/comlist.html';

?>