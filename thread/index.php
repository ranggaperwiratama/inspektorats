<div class="row-fluid">
    <ul class="breadcrumb">
    <?php if ($type == 'category'): ?>
    <li>
        <a href="<?php echo site_url('thread'); ?>">Beranda</a>
        <span class="divider">/</span>
    </li>
    <?php $cat_total = count($cat); foreach ($cat as $key => $c): ?>
    <li>        
        <a href="<?php echo site_url('thread/category/'.$c['slug']); ?>"><?php echo $c['name']; ?></a> 
        <?php if ($key+1 != $cat_total): ?>
        <span class="divider">/</span>
        <?php endif; ?>
    </li>
    <?php endforeach; ?>
    <?php else: ?>
    <li>
        <a href="<?php echo site_url('thread'); ?>">Beranda</a>
    </li>
    <?php endif; ?>
    </ul>
    <?php
    function time_ago($date) {

        if(empty($date)) {
            return "No date provided";
        }

        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60","60","24","7","4.35","12","10");
        $now = time();
        $unix_date = strtotime($date);

        // check validity of date

        if(empty($unix_date)) {
            return "Bad date";
        }

        // is it future date or past date
        if($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";
        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }
        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }
        $difference = round($difference);
        if($difference != 1) {
            $periods[$j].= "s";
        }

        return "$difference $periods[$j] {$tense}";
    }
    ?>
	<script>
	window.onload = $(function () {
		var chart = new CanvasJS.Chart("chartContainer",
		{
			title:{
				text: "Perbandingan Pertanyaan dan Jawaban"
			},
			legend: {
				maxWidth: 350,
				itemWidth: 120
			},
			data: [
			{
				type: "pie",
				showInLegend: false,
				legendText: "{indexLabel}",
				dataPoints: [
					{ y: <?php echo $pertanyaan; ?>, indexLabel: "Pertanyaan" },
					{ y: <?php echo $jawaban; ?>, indexLabel: "Jawaban" }
				]
			}
			]
		});
		chart.render();
	})
	</script>
	<?php $selisih = $pertanyaan - $jawaban?>
    <style>table td, table th {padding:10px 7px !important;} .cat {font-weight:bold;font-size: 10px;color: #333;font-style: italic;}</style>
    <table class="table table-striped table-condensed">
    <thead>
        <tr>
            <th width="85%">Semua Pertanyaan</th>
            <th width="15%">Update Terakhir</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($threads as $thread): ?>
        <tr>
        <td style="font-size:12px;">
            <a style="font-family: verdana;" href="<?php echo site_url('thread/talk/'.$thread->slug); ?>"><?php echo $thread->title; ?></a>
            <span style="display: block">
                <a href="<?php echo site_url('thread/category/'.$thread->category_slug); ?>" class="cat">Kategori: <?php echo $thread->category_name; ?></a>
            </span>
        </td>
        <td style="font-size:12px;color:#999;vertical-align: middle;">
            <!-- <?php echo date("m/d/y g:i A", strtotime($thread->date_add)); ?> -->
            <?php echo time_ago($thread->date_add); ?>
        </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
    <div class="page-header">
		<div id="chartContainer" style="height: 300px; width: 100%;"></div>
		<br>
		<center><h3><?php echo $selisih; ?> pertanyaan belum dijawab</h3></center>
	</div>
    <div class="pagination" style="text-align:center;">
        <ul><?php echo $page; ?></ul>
    </div>
<div>