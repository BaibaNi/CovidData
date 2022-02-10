<?php
//echo "<pre>";
$limit = 1000;
$offset = $_GET["offset"] ?? 0;

$from = $_GET["from"] ?? "";
$to = $_GET["to"] ?? "";

$data = json_decode(file_get_contents(
        "https://data.gov.lv/dati/lv/api/3/action/datastore_search?&offset=$offset&resource_id=d499d2f0-b1ea-4ba2-9600-2c701b03bd4a&limit=$limit"));
?>

<html>
<head><b>COVID-19 STATISTICS</b></head>
<body>
    <form method="get" action="/">
        <p>Choose the time period.</p>
        From: <input type="date" name="from" value="<?php echo $from; ?>"/>
        To:   <input type="date" name="to" value="<?php echo $to; ?>"/>
              <button type="submit" data-value="<?php echo $from; ?>" value="<?php echo $to; ?>"> Filter </button>
    </form>
    <table style="border: crimson solid" border="crimson solid" >
        <tr>
            <th>Date</th>
            <th>Total tests</th>
            <th>Positive tests</th>
            <th>%</th>
        </tr>
            <?php foreach($data->result->records as $cases): ?>
                <?php if(strtotime($cases->Datums) >= strtotime($from) && strtotime($cases->Datums) <= strtotime($to)): ?>
                    <tr>
                        <td><?php echo date_format(date_create(substr($cases->Datums, 0, "10")), "d-m-Y"); ?></td>
                        <td><?php echo $cases->TestuSkaits; ?></td>
                        <td><?php echo $cases->ApstiprinataCOVID19InfekcijaSkaits; ?></td>
                        <td><?php echo $cases->Ipatsvars; ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
    </table>
<!--    <form method="get" action="/">-->
<!--        --><?php //if($offset > 0): ?>
<!--            <button type="submit" name="offset" value="--><?php //echo $offset - $limit; ?><!--"> ← Previous page </button>-->
<!--        --><?php //endif; ?>
<!---->
<!--        --><?php //if(count($data->result->records) >= $limit): ?>
<!--            <button type="submit" name="offset" value="--><?php //echo $offset + $limit; ?><!--"> Next page → </button>-->
<!--        --><?php //endif; ?>
<!--    </form>-->
</body>
</html>

