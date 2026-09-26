<?php
require_once __DIR__.'/common.php';
if (isset($_GET['logout'])) { session_destroy(); header('Location: admin.php'); exit; }

$error='';
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['login'])) {
  $hash=hash('sha256', $_POST['password'] ?? '');
  if (hash_equals(ADMIN_PASSWORD_SHA256,$hash)) {
    $_SESSION['admin']=true; header('Location: admin.php'); exit;
  }
  $error='Incorrect password.';
}
if (!logged_in()):
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Login</title><link rel="stylesheet" href="styles.css"><style>
body{min-height:100vh;display:grid;place-items:center;background:#eef6ff}.login{width:min(430px,calc(100% - 28px));background:#fff;padding:35px;border-radius:24px;box-shadow:0 20px 60px #071a3520}.login h1{font-size:34px;margin:10px 0}.login input{width:100%;padding:14px;border:1px solid #e2e8f0;border-radius:12px;margin:12px 0}.login button{width:100%;border:0;cursor:pointer}
</style></head><body><form class="login" method="post"><div class="logo"><span class="logo-mark">M</span> Admin Panel</div><h1>Welcome back.</h1><p style="color:#66758b">Manage your website content from one place.</p>
<?php if($error): ?><p style="color:#d33"><?=esc($error)?></p><?php endif; ?>
<input type="password" name="password" placeholder="Admin password" required><button class="btn" name="login">Login →</button>
<p style="font-size:12px;color:#8997aa;margin-top:15px">Change the default password in <b>config.php</b> before publishing.</p></form></body></html>
<?php exit; endif;

$d=data();
$msg='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  if(isset($_POST['save_settings'])){
    $d['settings']['brand']=trim($_POST['brand']);
    $d['settings']['email']=trim($_POST['email']);
    $d['settings']['phone']=trim($_POST['phone']);
    $d['settings']['whatsapp']=preg_replace('/\D+/','',$_POST['whatsapp']);
    $d['settings']['location']=trim($_POST['location']);
    save_data($d); $msg='Settings saved.';
  }
  if(isset($_POST['save_services'])){
    $items=[];
    foreach(($_POST['service_title']??[]) as $i=>$v){
      if(trim($v)!=='') $items[]=['title'=>trim($v),'description'=>trim($_POST['service_description'][$i]??''),'icon'=>trim($_POST['service_icon'][$i]??'')];
    }
    $d['services']=$items; save_data($d); $msg='Services saved.';
  }
  if(isset($_POST['save_projects'])){
    $items=[];
    foreach(($_POST['project_title']??[]) as $i=>$v){
      if(trim($v)!=='') $items[]=['title'=>trim($v),'type'=>trim($_POST['project_type'][$i]??''),'theme'=>trim($_POST['project_theme'][$i]??'blue')];
    }
    $d['projects']=$items; save_data($d); $msg='Projects saved.';
  }
  if(isset($_POST['save_posts'])){
    $items=[];
    foreach(($_POST['post_title']??[]) as $i=>$v){
      if(trim($v)!=='') $items[]=['title'=>trim($v),'category'=>trim($_POST['post_category'][$i]??''),'excerpt'=>trim($_POST['post_excerpt'][$i]??'')];
    }
    $d['posts']=$items; save_data($d); $msg='Blog posts saved.';
  }
}
$inq=json_decode(file_get_contents(INQUIRIES_FILE),true) ?: [];
?>
<!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Dashboard</title><link rel="stylesheet" href="styles.css"><style>
.admin{background:#f5f8fc;min-height:100vh}.adminbar{background:#071a35;color:#fff;padding:15px 0}.adminbar .container{display:flex;justify-content:space-between;align-items:center}.panel{background:#fff;border:1px solid #e5ebf3;border-radius:20px;padding:24px;margin:20px 0}.panel h2{margin-top:0}.fields{display:grid;grid-template-columns:1fr 1fr;gap:12px}.fields input,.fields textarea,.row input,.row select{width:100%;padding:11px;border:1px solid #dfe7f1;border-radius:10px;font:inherit}.fields textarea{min-height:90px}.row{display:grid;grid-template-columns:1fr 1.3fr 100px 45px;gap:10px;margin:9px 0}.row.post{grid-template-columns:1.2fr 130px 1.4fr 45px}.remove{border:0;border-radius:10px;background:#ffe8e8;color:#c33;cursor:pointer}.smallbtn{border:0;background:#eaf2ff;color:#1769ff;padding:9px 13px;border-radius:10px;font-weight:800;cursor:pointer}.save{border:0;cursor:pointer;margin-top:12px}.statbar{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}.statbox{background:#eef6ff;border-radius:15px;padding:18px}.statbox b{font-size:28px;color:#1769ff}
@media(max-width:700px){.fields,.statbar{grid-template-columns:1fr}.row,.row.post{grid-template-columns:1fr}.adminbar .container{gap:10px;flex-wrap:wrap}}
</style></head><body class="admin">
<div class="adminbar"><div class="container"><b>✦ Maya Digital Studio — Admin</b><a href="index.php" style="color:#fff">View Website ↗</a><a href="admin.php?logout=1" style="color:#ffd22e">Logout</a></div></div>
<div class="container">
<?php if($msg): ?><div class="panel" style="border-color:#b9e6d2;color:#16865e"><?=esc($msg)?></div><?php endif; ?>
<div class="statbar" style="margin-top:20px"><div class="statbox"><b><?=count($d['services'])?></b><br>Services</div><div class="statbox"><b><?=count($d['projects'])?></b><br>Projects</div><div class="statbox"><b><?=count($inq)?></b><br>Inquiries</div></div>

<form class="panel" method="post"><h2>Site Settings</h2><div class="fields">
<input name="brand" value="<?=esc($d['settings']['brand'])?>" placeholder="Brand">
<input name="email" type="email" value="<?=esc($d['settings']['email'])?>" placeholder="Email">
<input name="phone" value="<?=esc($d['settings']['phone'])?>" placeholder="Phone">
<input name="whatsapp" value="<?=esc($d['settings']['whatsapp'])?>" placeholder="WhatsApp international number">
<input name="location" value="<?=esc($d['settings']['location'])?>" placeholder="Location">
</div><button class="btn save" name="save_settings">Save Settings</button></form>

<form class="panel" method="post"><h2>Services</h2><div id="services"><?php foreach($d['services'] as $x): ?><div class="row"><input name="service_title[]" value="<?=esc($x['title'])?>"><input name="service_description[]" value="<?=esc($x['description'])?>"><input name="service_icon[]" value="<?=esc($x['icon'])?>"><button type="button" class="remove" onclick="this.parentElement.remove()">×</button></div><?php endforeach; ?></div><button type="button" class="smallbtn" onclick="addService()">+ Add Service</button><br><button class="btn save" name="save_services">Save Services</button></form>

<form class="panel" method="post"><h2>Portfolio Projects</h2><div id="projects"><?php foreach($d['projects'] as $x): ?><div class="row"><input name="project_title[]" value="<?=esc($x['title'])?>"><input name="project_type[]" value="<?=esc($x['type'])?>"><select name="project_theme[]"><option <?=($x['theme']=='blue'?'selected':'')?>>blue</option><option <?=($x['theme']=='yellow'?'selected':'')?>>yellow</option><option <?=($x['theme']=='green'?'selected':'')?>>green</option></select><button type="button" class="remove" onclick="this.parentElement.remove()">×</button></div><?php endforeach; ?></div><button type="button" class="smallbtn" onclick="addProject()">+ Add Project</button><br><button class="btn save" name="save_projects">Save Projects</button></form>

<form class="panel" method="post"><h2>Blog Posts</h2><div id="posts"><?php foreach($d['posts'] as $x): ?><div class="row post"><input name="post_title[]" value="<?=esc($x['title'])?>"><input name="post_category[]" value="<?=esc($x['category'])?>"><input name="post_excerpt[]" value="<?=esc($x['excerpt'])?>"><button type="button" class="remove" onclick="this.parentElement.remove()">×</button></div><?php endforeach; ?></div><button type="button" class="smallbtn" onclick="addPost()">+ Add Post</button><br><button class="btn save" name="save_posts">Save Posts</button></form>

<div class="panel"><h2>Recent Inquiries</h2><?php if(!$inq): ?><p style="color:#66758b">No inquiries yet.</p><?php else: foreach(array_slice(array_reverse($inq),0,20) as $x): ?><div style="border-top:1px solid #edf1f6;padding:15px 0"><b><?=esc($x['name'])?></b> · <?=esc($x['email'])?><br><small><?=esc($x['service'])?> · <?=esc($x['created'])?></small><p><?=nl2br(esc($x['message']))?></p></div><?php endforeach; endif; ?></div>
</div>
<script>
function addService(){document.getElementById('services').insertAdjacentHTML('beforeend','<div class="row"><input name="service_title[]" placeholder="Service title"><input name="service_description[]" placeholder="Description"><input name="service_icon[]" placeholder="Icon"><button type="button" class="remove" onclick="this.parentElement.remove()">×</button></div>')}
function addProject(){document.getElementById('projects').insertAdjacentHTML('beforeend','<div class="row"><input name="project_title[]" placeholder="Project title"><input name="project_type[]" placeholder="Project type"><select name="project_theme[]"><option>blue</option><option>yellow</option><option>green</option></select><button type="button" class="remove" onclick="this.parentElement.remove()">×</button></div>')}
function addPost(){document.getElementById('posts').insertAdjacentHTML('beforeend','<div class="row post"><input name="post_title[]" placeholder="Post title"><input name="post_category[]" placeholder="Category"><input name="post_excerpt[]" placeholder="Excerpt"><button type="button" class="remove" onclick="this.parentElement.remove()">×</button></div>')}
</script></body></html>