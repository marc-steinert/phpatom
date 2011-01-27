<?php

function __logo() {
    $url = __user()->getCustomer()->getLogo()->getLogoUrl();
    
   ?>
    <div style="border-bottom: 1px solid #E0E0E0;  margin:0 0 20px; text-align: center; padding-bottom: 10px;">
            <h1 id="title">
                <a href=""><img src="<?php echo $url; ?>" alt="autarchic.net" /></a>
            </h1>
            <div>
                <?php
                    __e(
                        'Logged in as !firstname !lastname',
                        array(
                            '!firstname' =>  __user()->Firstname,
                            '!lastname' => __user()->Lastname
                        )
                    );
                ?>
            </div>
            <div>
                <a href="/settingsuser"><?php __e('Settings'); ?></a>&nbsp; | &nbsp;
                <a href="/logout"><?php __e('Logout'); ?></a>
            </div>
        </div>
     <?php
}
