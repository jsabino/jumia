<?php
use App\Enums\PhoneNumberState;

/**
 * @var \App\Domain\Maps\CountryMap $countries
 * @var array $old
 */
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css" crossorigin="anonymous">

    <title>Phone Numbers</title>
</head>
<body>

<div class="container">
    <h1>Phone Numbers</h1>

    <form>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="countryCode">Select country</label>
                <select id="countryCode" class="filter form-control">
                    <option value="">Choose...</option>
                    <?php
                    foreach ($countries as $country) {
                        echo "<option value='{$country->getCode()}'>{$country->getName()}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group col-md-4">
                <label for="phoneNumberState">State of phone number</label>
                <select id="phoneNumberState" class="filter form-control">
                    <option value="">Choose...</option>
                    <?php
                    foreach (PhoneNumberState::toSelectArray() as $key => $value) {
                        echo "<option value='{$key}'>{$value}</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
    </form>

    <div class="row">
        <div class="col">
            <table id="table_phone_numbers" class="table">
            <thead>
            <tr>
                <th>Country</th>
                <th>State</th>
                <th>Country Code</th>
                <th>Phone Number</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>
</div>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
<script src="/public/js/home.js"></script>

</body>
</html>
