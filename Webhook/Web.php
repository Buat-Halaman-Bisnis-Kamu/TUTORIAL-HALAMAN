<?php
if ($_GET['hub_verify_token'] === 'MDM6QXBwMTUzNjg') {
  echo $_GET['hub_challenge'];
}
