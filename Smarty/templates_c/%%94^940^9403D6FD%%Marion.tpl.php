<?php /* Smarty version 2.6.18, created on 2014-09-25 13:14:30
         compiled from Marion.tpl */ ?>
<link type="text/css" rel="stylesheet" href="include/components/bootstrap/dist/css/bootstrap.css" />
<link type="text/css" rel="stylesheet" href="include/components/bootstrap-datepicker/css/datepicker.css" />

<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php?module=<?php echo $this->_tpl_vars['MODULE']; ?>
&action=index"><?php echo $this->_tpl_vars['MODULE']; ?>
</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	
      <!-- ul class="nav navbar-nav">
        <li class="active"><a href="#">Link</a></li>
      </ul -->	  
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div id="main-content"></div>
<div id="footer"></div>

<script data-main="modules/<?php echo $this->_tpl_vars['MODULE']; ?>
/marion/main.js" src="include/components/requirejs/require.js"></script>