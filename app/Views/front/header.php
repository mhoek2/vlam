<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>VLAM Training - REA College</title>
    <meta name="description" content="The small framework with powerful features">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?=setCSRFHeaderMeta()?>
	
	<link rel="shortcut icon" type="image/png" href="<?=base_url('favicon.ico')?>">
	<link rel="apple-touch-icon" sizes="180x180" href="<?=base_url('apple-touch-icon.png')?>">
	<link rel="icon" type="image/png" sizes="32x32" href="<?=base_url('favicon-32x32.png')?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?=base_url('favicon-16x16.png')?>">
	<link rel="manifest" href="<?=base_url('site.webmanifest')?>">
	
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Saira+Stencil+One&display=swap" rel="stylesheet">
	
    <link rel="stylesheet" href="<?=base_url('assets/css/header.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/frontend.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/meeting.css')?>">

    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/44.1.0/ckeditor5.css">
    
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
	
    <script src="https://code.jquery.com/jquery-3.7.1.js"
            integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"></script>
</head>
<body>

<header>
    <div class="menu">
        <ul>
            <li class="menu-toggle">
                <button id="menuToggle">&#9776;</button>
            </li>
            <li class="menu-item hidden <?=(current_url() === url_to('home')) ? 'active' : '' ?>">
				<a href="<?=site_url()?>">
					<i class="fa-solid fa-house-chimney"></i> Home
				</a>
			</li>
        </ul>
        <ul>
            <li class="logo">
                <a href="<?=site_url()?>">
					<img src="<?=base_url('assets/images/logo.svg')?>" width="50"/>
					<span><b>VLAM</b> Training</span>
                </a>
            </li>
        <?php if ($user): ?>
            <input type="checkbox" id="user_dropdown"/>
            <label for="user_dropdown"><?=$user["shortname"]?></label>
            <ul class="user_dropdown">
                <div class="titlebar">
                    <span><b>VLAM</b> Training</span>
                    <a href="<?=site_url()."logout"?>">Logout</a>
                </div>
                <div class="userinfo">
                    <div class="profile"><?=$user["shortname"]?></div>
                    <div class="meta">
                        <span><b><?=$user["firstname"]?> <?=$user["middlename"]?></b> <?=$user["lastname"]?></span>
                        <span class="email"><?=$user["username"]?></span>
                    </div>
                </div>
                <ul>
                    <?php if($user["is_admin"]): ?>
                        <li><a href="<?=base_url(route_to('admin'))?>">Beheerpaneel</a></li>
                    <?php endif ?>
                </ul>
            </ul>
        <?php endif ?>
        </ul>
    </div>
</header>