<?php
require '../inc/config.php';
include '../inc/mysql.php';
if (!isset($_COOKIE['user'])) {
    header("Location: " . BASE_URL);
    die();
}
include VIEW_HEADER
?>
<div data-role="page">
    <?php
    $title = "Enterprise Asset Management";
    include VIEW_HEADER_PAGE
    ?>
    <div data-role="main" class="ui-content">
        <style>
            .expert-list thead th,
            .expert-list tbody tr:last-child {
                border-bottom: 1px solid #d6d6d6; /* non-RGBA fallback */
                border-bottom: 1px solid rgba(0,0,0,.1);
            }
            .expert-list tbody th,
            .expert-list tbody td {
                border-bottom: 1px solid #e6e6e6; /* non-RGBA fallback  */
                border-bottom: 1px solid rgba(0,0,0,.05);
            }
            .expert-list tbody tr:last-child th,
            .expert-list tbody tr:last-child td {
                border-bottom: 0;
            }
            .expert-list tbody tr:nth-child(odd) td,
            .expert-list tbody tr:nth-child(odd) th {
                background-color: #eeeeee; /* non-RGBA fallback  */
                background-color: rgba(0,0,0,.04);
            }
        </style>
        <?php
        $sql = "SELECT * FROM expert WHERE product_product_id = 1 ORDER BY expert_status DESC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <div data-role="collapsible" data-collapsed="true">
                    <h4><?= $row["expert_name"] ?></h4>
                    <table data-role="table" id="movie-table-custom" data-mode="reflow" class="expert-list ui-responsive">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Curriculum Vitae</th>
                                <th>Rate</abbr></th>
                                <th>Experience</th>
                                <th>Reputation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th><?= $row["expert_status"] ?></th>
                                <td><a href="<?= BASE_URL . 'doc/' . $row["expert_doc"] ?>" data-ajax="false" target="_blank">Download</a></td>
                                <td>Rp <?= number_format($row["expert_rate"], 2, ",", ".") ?>/day</td>
                                <td><?= $row["expert_experience"] ?> years</td>
                                <td><?= $row["expert_reputation"] ?>/5</td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="<?= BASE_URL ?>order.php?expert_id=<?= $row["expert_id"] ?>" data-ajax="false" class="ui-btn">Choose</a>
                </div>
                <?php
            }
        } else {
            ?>
            <a href="<?= BASE_URL ?>recruitment.php" data-ajax="false" class="ui-btn">Open Recruitment</a>
            <?php
        }
        $conn->close();
        ?>

    </div>
    <?php include VIEW_COPYRIGHT ?>
</div>
<?php include VIEW_FOOTER ?>
