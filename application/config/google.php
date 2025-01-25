<?php

defined('BASEPATH') OR exit('No direct script access allowed');



/*

| -------------------------------------------------------------------

|  Google API Configuration

| -------------------------------------------------------------------

| 

| To get API details you have to create a Google Project

| at Google API Console (https://console.developers.google.com)

| 

|  client_id         string   Your Google API Client ID.

|  client_secret     string   Your Google API Client secret.

|  redirect_uri      string   URL to redirect back to after login.

|  application_name  string   Your Google application name.

|  api_key           string   Developer key.

|  scopes            string   Specify scopes

*/

$config['google']['client_id']        = '567903877184-uqdm14jo2vsapg6lj5ukv8hj9n9rnqm5.apps.googleusercontent.com';

$config['google']['client_secret']    = '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';

$config['google']['redirect_uri']     = 'http://localhost/searchmerch/login/googlelogin';

$config['google']['application_name'] = 'Google Login';

$config['google']['api_key']          = '';

$config['google']['scopes']           = array();