<?php
require './inc/config.php';
if (!isset($_COOKIE['user'])) {
    header("Location: " . BASE_URL);
    die();
}
include './inc/mysql.php';
include VIEW_HEADER;
$expert_id = isset($_GET['expert_id']) ? $_GET['expert_id'] : '';
$result = mysqli_query($conn, "SELECT * FROM expert, product WHERE expert_id = " . htmlspecialchars($expert_id) . " AND product_id = product_product_id");
$row = mysqli_fetch_assoc($result);
$id = $row['expert_id'];
$name = $row['expert_name'];
$rate = $row['expert_rate'];
$reputation = $row['expert_reputation'];
$doc = $row['expert_doc'];
$experience = $row['expert_experience'];
$status = $row['expert_status'];
$product = $row['product_name'];
?>
<div data-role="page">
    <script>
        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        $(function () {
            $('input[name=duration]').keyup(function () {
                $('#price').val('Rp ' + numberWithCommas($('#duration').val() * <?= $rate ?>) + ',00');
                $('input[name=price]').val($('#duration').val() * <?= $rate ?>);
            });
            $('#hidden-province').hide();
            $('form input').on('change', function () {
                if ($('input[name=onsite]:checked', 'form').val() === 'no') {
                    $('#hidden-province').hide();
                } else {
                    $('#hidden-province').show();
                }
            });
            $('form').validate({
                rules: {
                    duration: {
                        required: true
                    },
                    start: {
                        required: true
                    }
                },
                messages: {
                    duration: {
                        required: "Please enter your duration job."
                    },
                    start: {
                        required: "Please enter start date job."
                    }
                },
                errorPlacement: function (error, element) {
                    error.appendTo(element.parent().prev());
                },
                submitHandler: function (form) {
                    $.mobile.loading('show', {text: "Please wait...", textonly: false, textVisible: true});
                    var strData = $(form).serialize();
                    $.ajax({
                        type: "POST",
                        url: site + "invoice.php",
                        data: strData,
                        dataType: "json",
                        success: function (msg) {
                            if (JSON.parse(msg['success']) === 1) {
                                $.mobile.loading('hide');
                                window.location = site + 'checkout.php';
                            } else {
                                $.mobile.loading('hide');
                                window.location = site + 'index.php?notify=error';
                            }
                        }
                    });
                }
            });
        });
    </script>

    <?php
    $title = $product;
    include VIEW_HEADER_PAGE
    ?>
    <div data-role="main" class="ui-content">
        <?php
        if (!empty(htmlspecialchars($expert_id))) {
            ?>
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
            <div data-role="collapsible" data-collapsed="true">
                <h4><?= $name ?></h4>
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
                            <th><?= $status ?></th>
                            <td><a href="<?= BASE_URL . 'doc/' . $doc ?>" data-ajax="false" target="_blank">Download</a></td>
                            <td>Rp <?= number_format($rate, 2, ",", ".") ?>/day</td>
                            <td><?= $experience ?> years</td>
                            <td><?= $reputation ?>/5</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <form method="post">
                <input type="hidden" name="product" value="<?= $product ?>">
                <input type="hidden" name="ajax" value="1">
                <input type="hidden" name="expert_id" value="<?= $id ?>">
                <input type="hidden" name="customer_id" value="<?= $_COOKIE['user'] ?>">
                <label for="duration">Duration</label>
                <input type="number" data-clear-btn="true" name="duration" id="duration">
                <label for="price">Price</label>
                <input type="text" data-clear-btn="true" id="price" disabled="yes">
                <input type="hidden" name="price">
                <label for="start">Start</label>
                <input type="date" data-clear-btn="true" name="start" id="start">
                <fieldset data-role="controlgroup" data-type="horizontal">
                    <legend>On Site</legend>
                    <input type="radio" name="onsite" id="yes" value="yes">
                    <label for="yes">Yes</label>
                    <input type="radio" name="onsite" id="no" value="no" checked="checked">
                    <label for="no">No</label>
                </fieldset>
                <div id="hidden-province">
                    <label for="province">Province</label>
                    <select name="province" id="province">
                        <option value="Aceh">Aceh</option>
                        <option value="Bali">Bali</option>
                        <option value="Banten">Banten</option>
                        <option value="Bengkulu">Bengkulu</option>
                        <option value="Gorontalo">Gorontalo</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Jambi">Jambi</option>
                        <option value="Jawa Barat">Jawa Barat</option>
                        <option value="Jawa Tengah">Jawa Tengah</option>
                        <option value="Jawa Timur">Jawa Timur</option>
                        <option value="Kalimantan Barat">Kalimantan Barat</option>
                        <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                        <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                        <option value="Kalimantan Timur">Kalimantan Timur</option>
                        <option value="Kalimantan Utara">Kalimantan Utara</option>
                        <option value="Kepulauan Bangka Belitung">Kepulauan Bangka Belitung</option>
                        <option value="Kepulauan Riau">Kepulauan Riau</option>
                        <option value="Lampung">Lampung</option>
                        <option value="Maluku">Maluku</option>
                        <option value="Maluku Utara">Maluku Utara</option>
                        <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                        <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                        <option value="Papua">Papua</option>
                        <option value="Papua Barat">Papua Barat</option>
                        <option value="Riau">Riau</option>
                        <option value="Sulawesi Barat">Sulawesi Barat</option>
                        <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                        <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                        <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                        <option value="Sulawesi Utara">Sulawesi Utara</option>
                        <option value="Sumatera Barat">Sumatera Barat</option>
                        <option value="Sumatera Selatan">Sumatera Selatan</option>
                        <option value="Sumatera Utara">Sumatera Utara</option>
                        <option value="Yogyakarta">Yogyakarta</option>
                    </select>
                </div>
                <button class="ui-shadow ui-btn ui-corner-all">Checkout</button>
            </form>
        <?php }
        ?>
    </div>
    <?php include VIEW_COPYRIGHT ?>
</div>
<?php include VIEW_FOOTER ?>
