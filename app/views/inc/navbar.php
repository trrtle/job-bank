<?php
/**
 * inc/navbar.php - navigation menu that is included on the header
 *
 * @package    TurtleMVC-Core
 * @license    https://opensource.org/licenses/BSD-3-Clause
 * @author     Micky Aarnoudse
 * @copyright  2020 Micky Aarnoudse
 * @uses bootstrap4
 */
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3 shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="<?php echo URLROOT;?>">
            <?php echo SITENAME;?>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT;?>">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT . "pages/about";?>">About</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <?php if(user_isLoggedIn()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT . "Users/dashboard";?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT . "users/profile/" . $_SESSION["username"];?>">Profiel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT . "users/logout";?>">logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT . "users/settings";?>">
                            <i class="fa fa-cog"></i>
                        </a>
                    </li>
                <?php elseif(comp_isLoggedIn()):?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT . "Companys/dashboard";?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT . "companys/profile/" . $_SESSION["comp_username"];?>">Profiel</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT . "companys/logout";?>">logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT . "companys/settings";?>">
                            <i class="fa fa-cog"></i>
                        </a>
                    </li>
                <?php elseif(admin_isLoggedIn()):?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT . "Admins/dashboard";?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT . "Admins/logout";?>">logout</a>
                    </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT . "users/login";?>">Werkzoekend</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT . "Companys/login";?>">Werkgevers</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
