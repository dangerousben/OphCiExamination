<?php

$et = EventType::model()->find('class_name=\'OphCiExamination\'');
$api = $et->getApi();
$iops_left = $api->getIOPs($this->episode);
$iops_right = $api->getIOPs($this->episode);

//Yii::app()->getModule('OphCiExamination');
// set up the chart data:
$chart = new FlotChart();

$chart->registerScript('/js/libs/chart/flot/jquery.js');
$chart->registerScript('/js/libs/chart/flot/excanvas.js');
$chart->registerScript('/js/libs/chart/flot/jquery.flot.js');
$chart->registerScript('/js/libs/chart/flot/jquery.flot.time.js');
$chart->registerScript('/js/libs/chart/flot/jquery.flot.navigate.js');

$le = array();
$re = array();

foreach ($api->getIOPs($this->episode) as $index => $data) {
  $le = $chart->array_push_assoc($le, $index, $data->left_reading->name);
  $re = $chart->array_push_assoc($re, $index, $data->right_reading->name);
}

$chart->addPlots('d1', $re, "LE");
$chart->addPlots('d2', $le, "RE");
$chart->addZoomXAxis(3, 50);
$chart->addZoomYAxis(0.1, 10);
$chart->addPanXAxis(0, count($api->getIOPs($this->episode)) - 1);
$chart->addPanYAxis(0, 60);
$chart->addHover('tooltip', -25, 5, 1, 'solid', 'fdd', 2, 'fee', 0.80, 
        200, 'hoverdata', "IOP: ");
$chart->setYAxisLabels(array(0 => 0, 05 => 05, 10 => 10, 15 => 15, 20 => 20, 25 => 25, 30 => 30, 35 => 35, 40 => 40, 45 => 45, 50 => 50, 55 => 55, 60 => 60,));
$xaxis = array();
foreach ($api->getIOPs($this->episode) as $data) {
  array_push($xaxis, substr($data->created_date, 2, 8));
}
$chart->setXAxisLabels($xaxis, $timeData = true);
?>

<div id="placeholder" style="margin-left: auto;margin-right: auto;width:800px;height:300px"></div>
<!--<p>
  <span id="hoverdata"></span>
</p>-->
<?php
if (count($iops_left) > 1 || count($iops_right) > 1) {
?>

<script type="text/javascript">
<?php echo $chart->toString('placeholder');    ?>
</script>

<?php
} else if (count($iops_left) == 1 || count($iops_right) == 1) {
  // just display information about the specified IOP:
  ?>

  <div class="section" style="float: left; margin-left: 100px; ">
    <?php
    $iopLeft = "-";
    $iopRight = "-";
    if (count($iops_left)) {
      $iopLeft = $iops_left[0];
    }
    if (count($iops_right)) {
      $iopRight = $iops_right[0];
    }
    echo "There is only 1 recorded IOP for this patient (RE/LE): "
    . $iopRight . " / " . $iopLeft
    . "<br>At least two (2) IOPs must be recorded for the graph to be drawn.";
    ?>
  </div>
  <div style="clear: both"></div> 
  <?php
} else {
  ?>

  <div class="section" style="float: left; margin-bottom: 10px; margin-top: 10px; margin-left: 100px; ">
    <?php echo "There are no IOPs recorded for this patient."; ?>
  </div>
  <div style="clear: both"></div> 
  <?php
}
?>