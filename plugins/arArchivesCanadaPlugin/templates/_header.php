<?php echo get_component_slot('header') ?>

<?php echo get_component('default', 'updateCheck') ?>

<?php if ($sf_user->isAuthenticated()): ?>
  <div id="top-bar">
    <nav>
      <?php echo get_component('menu', 'userMenu') ?>
      <?php echo get_component('menu', 'quickLinksMenu') ?>
      <?php if (sfConfig::get('app_toggleLanguageMenu')): ?>
        <?php echo get_component('menu', 'changeLanguageMenu') ?>
      <?php endif; ?>
      <?php echo get_component('menu', 'mainMenu', array('sf_cache_key' => $sf_user->getCulture().$sf_user->getUserID())) ?>
    </nav>
  </div>
<?php endif; ?>

<div id="header">

  <div class="container">

    <div id="header-lvl1">
      <div class="row">
        <div class="span12">

        
          <ul id="header-nav" class="nav nav-pills">

            <?php if ('fr' == $sf_user->getCulture()): ?>
              <li><?php echo link_to(__('Home'), 'http://localhost/homeFR') ?></li>
            <?php else: ?>
              <li><?php echo link_to(__('Home'), 'http://localhost') ?></li>
            <?php endif; ?>
            <li><a href="http://localhost:999/jikn/"> Website JIKN </a> </li>
            <?php if ('fr' == $sf_user->getCulture()): ?>
              <li><?php echo link_to(__('Contactez-nous'), array('module' => 'staticpage', 'slug' => 'contact')) ?></li>
            <?php else: ?>
              <li><?php echo link_to(__('About us'), array('module' => 'staticpage', 'slug' => 'about')) ?></li>
            <?php endif; ?>
            <?php if (!$sf_user->isAuthenticated()): ?>
              <li><?php echo link_to(__('Log in'), array('module' => 'user', 'action' => 'login')) ?></li>
            <?php endif; ?>

          </ul>

        </div>
      </div>
    </div>

    <div id="header-lvl2">
      <style type="text/css">
        #logo-and-name img {
          height:50px;
          width:200px;
        }
      </style>
      <div class="row">

        <div id="logo-and-name" class="span4">
          <?php if ('fr' == $sf_user->getCulture()): ?>
            <h1><?php echo link_to(image_tag('/plugins/arArchivesCanadaPlugin/images/logo.png', array('alt' => __('Archives Canada'))), 'http://localhost/', array('rel' => 'home')) ?></h1>
          <?php else: ?>
            <h1><?php echo link_to(image_tag('/plugins/arArchivesCanadaPlugin/images/logo.png', array('alt' => __('Archives Canada'))), 'http://localhost', array('rel' => 'home')) ?></h1>
          <?php endif; ?>
        </div>

        <div id="header-search" class="span8">

          <?php echo get_component('search', 'box') ?>
              <?php echo get_component('menu', 'quickLinksMenu') ?>
        <?php echo get_component('menu', 'changeLanguageMenu') ?>

          <?php echo get_component('menu', 'clipboardMenu') ?>
        </div>

      </div>
    </div>

  </div>

</div>
