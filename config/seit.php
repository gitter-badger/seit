<?php

return [
    'version'       => '0.1',
    'owner'         => env('APP_OWNER', ''),
    // Read SSO related Settings from ENV
    'sso_callback'  => env('SSO_CALLBACK'),
    'sso_clientid'  => env('SSO_CLIENTID'),
    'sso_secret'    => env('SSO_SECRET'),
    'sso_uselive'   => env('SSO_USELIVE'),
    // Switch to Use TQ (live) or Sisi
    'crest_uselive' => env('CREST_USELIVE'),
    'error_limit'   => 60,
    'ban_grace'     => 60 * 24,
    'ban_limit'     => 20,
];
