<?php
require_once("twitteroauth/twitteroauth.php");

// �A�v���o�^�Ŏ擾����Consumer key��ݒ�
$consumer_key="30MDc4kbpD1T1IVrw0qw";
// �A�v���o�^�Ŏ擾����Consumer secret��ݒ�
$consumer_secret="LyfPQewKoHH6XK2tKU19K1fhHGWK09jOtICyls8B9Q";

$twitter = new TwitterOAuth($consumer_key, $consumer_secret);

// ���N�G�X�g�g�[�N���̎擾
$request_token = $twitter->getRequestToken();
// �F�ؗpURL�̎擾
$url = $twitter->getAuthorizeURL($request_token);

print "$url\n";
print "�ɃA�N�Z�X���C�A�N�Z�X����������\�������Ïؔԍ�����͂��Ă�������: ";

// �Ïؔԍ������
$pin = trim(fgets(STDIN));

// �Ïؔԍ�����A�N�Z�X�g�[�N�����擾����
$token = $twitter->getAccessToken($pin);
$oauth_token = $token["oauth_token"];
$oauth_token_secret = $token["oauth_token_secret"];

if(!empty($oauth_token) && !empty($oauth_token_secret)) {
  print "�������܂���\n";
  print "\$oauth_token=\"$oauth_token\";\n";
  print "\$oauth_token_secret=\"$oauth_token_secret\";\n";
  fgets(STDIN);
} else {
  print "���s���܂���\n";
}
?>