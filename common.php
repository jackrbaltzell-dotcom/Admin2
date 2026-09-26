<?php
require_once __DIR__.'/config.php';
function data() {
  return json_decode(file_get_contents(DATA_FILE), true);
}
function save_data($d) {
  file_put_contents(DATA_FILE, json_encode($d, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE), LOCK_EX);
}
function esc($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function logged_in() { return !empty($_SESSION['admin']); }
function require_admin() { if (!logged_in()) { header('Location: admin.php'); exit; } }
function wa_link($message) {
  $d=data(); return 'https://wa.me/'.preg_replace('/\D+/','',$d['settings']['whatsapp']).'?text='.rawurlencode($message);
}
