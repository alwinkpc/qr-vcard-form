<?php include __DIR__ . '/../vendor/autoload.php' ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="QR generator for vcards">
    <meta name="author" content="Alwin Kesler Pacheco">

    <title>vcard generator</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="css/default.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="container">
        <div class="page-header">
            <h1>QR generator for vcards</h1>
        </div>
  
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST') : ?>
        <div class="row qr-area">
            <div class="col-sm-12">
                <h3>Generated code</h3>
                <div class="text-center">
                    <?php
                        $support  = new App\Support();
                        $response = $support->generate($_POST);
                        if ($support->isValidQrCode($response)) {
                            $qr = base64_encode($response);
                            printf('<img src="data:image/png;base64,%s" />', $qr);

                        } else {
                            echo "Couldn't retrieve code from source";
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php endif ?>
  
        <div class="row">
            <div class="col-sm-12">
                <form method="POST" action="vcard.php">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $_POST['name'] ?: '' ?>" placeholder="Name" required="required" />
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="surname">Surname</label>
                                <input type="text" class="form-control" id="surname" name="surname" value="<?php echo $_POST['surname'] ?: '' ?>" placeholder="Surname" required="required" />
                            </div>
                        </div>
                    </div>
  
                    <h3>Work information</h3>
                    <div>
                        <div class="form-group">
                            <label for="organization">Organization</label>
                            <input type="text" class="form-control" id="organization" name="organization" value="<?php echo $_POST['organization'] ?: '' ?>" placeholder="Organization" />
                        </div>
                        <div class="form-group">
                            <label for="work_position">Position</label>
                            <input type="text" class="form-control" id="work_position" name="work_position" value="<?php echo $_POST['work_position'] ?: '' ?>" placeholder="Position" />
                        </div>
                        <div class="form-group">
                            <label for="work_address">Address</label>
                            <input type="text" class="form-control" id="work_address" name="work_address" value="<?php echo $_POST['work_address'] ?: '' ?>" placeholder="Address" />
                        </div>
                        <div class="form-group">
                            <label for="work_phone">Phone</label>
                            <input type="tel" class="form-control" id="work_phone" name="work_phone" value="<?php echo $_POST['work_phone'] ?: '' ?>" placeholder="Phone" />
                        </div>
                        <div class="form-group">
                            <label for="work_fax">Fax</label>
                            <input type="tel" class="form-control" id="work_fax" name="work_fax" value="<?php echo $_POST['work_fax'] ?: '' ?>" placeholder="Fax" />
                        </div>
                        <div class="form-group">
                            <label for="work_url">Website</label>
                            <input type="url" class="form-control" id="work_url" name="work_url" value="<?php echo $_POST['work_url'] ?: '' ?>" placeholder="Website" />
                        </div>
                        <div class="form-group">
                            <label for="work_email">Email</label>
                            <input type="email" class="form-control" id="work_email" name="work_email" value="<?php echo $_POST['work_email'] ?: '' ?>" placeholder="Email" />
                        </div>
                    </div>

                    <h3>Personal information</h3>
                    <div>
                        <div class="form-group">
                            <label for="home_address">Address</label>
                            <input type="text" class="form-control" id="home_address" name="home_address" value="<?php echo $_POST['home_address'] ?: '' ?>" placeholder="Address" />
                        </div>
                        <div class="form-group">
                            <label for="home_phone">Phone</label>
                            <input type="tel" class="form-control" id="home_phone" name="home_phone" value="<?php echo $_POST['home_phone'] ?: '' ?>" placeholder="Phone" />
                        </div>
                        <div class="form-group">
                            <label for="personal_phone">Cellphone</label>
                            <input type="tel" class="form-control" id="personal_phone" name="personal_phone" value="<?php echo $_POST['personal_phone'] ?: '' ?>" placeholder="Cellphone" />
                        </div>
                    </div>

                    <h3>Other</h3>
                    <div>
                        <div class="form-group">
                            <label for="revision">Revision</label>
                            <input type="text" class="form-control" id="revision" name="revision" value="<?php echo date('Ymd\THis\Z') ?>" placeholder="Revision" required="required" />
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="width">Width</label>
                                    <input type="number" class="form-control" id="width" name="width" value="<?php echo $_POST['width'] ?: 500 ?>" placeholder="Width" required="required" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="height">Height</label>
                                    <input type="number" class="form-control" id="height" name="height" value="<?php echo $_POST['width'] ?: 500 ?>" required="required" placeholder="Height" />
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="ecl">Error correction level</label>
                                    <select class="form-control" id="ecl" name="ecl" required="required">
                                        <?php
                                            $options = array(
                                                'L' => '<strong>L</strong> - [Default] Allows recovery of up to 7% data loss',
                                                'M' => '<strong>M</strong> - Allows recovery of up to 15% data loss',
                                                'Q' => '<strong>Q</strong> - Allows recovery of up to 25% data loss',
                                                'H' => '<strong>H</strong> - Allows recovery of up to 30% data loss',
                                            );

                                            foreach ($options as $key => $value) {
                                                $selected = ($key == $_POST['ecl'] ? 'selected="selected"' : '');
                                                printf('<option value="%s" %s>%s</option>', $key, $selected, $value);
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="margin">Margin</label>
                                    <input type="number" class="form-control" id="margin" name="margin" value="<?php echo $_POST['margin'] ?: 2 ?>" placeholder="Margin" required="required" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-right form-buttons">
                        <input type="reset" class="btn btn-default" value="Reset" />
                        <input type="submit" class="btn btn-primary" value="Submit" />
                    </div>
                </form>
            </div>
        </div>
    </div>


    <footer class="footer">
      <div class="container">
        <p class="text-muted">
            <small>This code supports on google's </small>
            Alwin Kesler Pacheco @<?php echo date('Y') ?>
        </p>
      </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
