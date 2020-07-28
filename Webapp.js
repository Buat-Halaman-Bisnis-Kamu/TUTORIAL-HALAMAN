file_put_contents(
  'log.txt',
  "\n" . file_get_contents('php://input'),
  FILE_APPEND
);
