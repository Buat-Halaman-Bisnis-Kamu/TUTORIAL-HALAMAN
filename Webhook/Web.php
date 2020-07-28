<?php
if ($_GET['hub_verify_token'] === 'make-up-a-token') {
  echo $_GET['hub_challenge'];
}
