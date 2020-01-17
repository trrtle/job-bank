<?php
require APPROOT . "/views/inc/header.php";
/** @var array $data */
?>

<div class="row">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
<!--        <pre>--><?php //print_r($data['data']) ?><!--</pre>-->
            <h2>Wachtwoord resetten</h2>
            <p>Vul hier je email adres en nieuwe wachtwoord in</p>
            <form action="<?php echo URLROOT . "users/passwordReset/" . $data['token']?>" method="post">
                <div class="form-group">
                    <label for="email">email<sup>*</sup></label>
                    <input type="email" name="email" class="form-control form-control-lg
                    <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="secret">Nieuwe Wachtwoord <sup>*</sup></label>
                    <input type="password" name="secret" class="form-control form-control-lg
                    <?php echo (!empty($data['secret_err'])) ? 'is-invalid' : ''; ?>" value="">
                    <span class="invalid-feedback"><?php echo $data['secret_err']; ?></span>
                </div>
                <div class="form-group">
                    <label for="secret_confirm">Herhaal nieuwe wachtwoord <sup>*</sup></label>
                    <input type="password" name="secret_confirm" class="form-control form-control-lg
                    <?php echo (!empty($data['secret_confirm_err'])) ? 'is-invalid' : ''; ?>" value="">
                    <span class="invalid-feedback"><?php echo $data['secret_confirm_err']; ?></span>
                </div>
<!--                <div class="row mb-3">-->
<!--                    <div class="col">-->
<!--                        <div class="g-recaptcha-->
<!--                            --><?php //echo (!empty($data['captcha_err'])) ? 'is-invalid' : ''; ?><!--"-->
<!--                             data-sitekey="6LdE4c4UAAAAACrE2_IoTA6cO48on4-WptN9Dbor"></div>-->
<!--                        <span class="invalid-feedback ">--><?php //echo $data['captcha_err']; ?><!--</span>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="row">
                    <div class="col-6">
                        <button type="submit" class="btn btn-success btn-block">Aanvragen</button>
                    </div>
                    <div class="col-6">
                        <a href="<?php echo URLROOT?>users/login">
                            <button type="button" class="btn btn-danger pull-right">
                                Terug
                            </button>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require APPROOT . "/views/inc/footer.php"?>
