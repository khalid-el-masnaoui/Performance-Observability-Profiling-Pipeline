import http from 'k6/http';
import { sleep } from 'k6';

const NGINX_URL = __ENV.NGINX_URL || "http://nginx";
