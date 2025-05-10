const CONFIG = {
    BACKEND_ENV: "PROD", //"PROD" for Production backend and "local" for local backend


    BACKEND_PROTOCOL: "http",
    BACKEND_LOCAL_IP: "localhost",
    BACKEND_PROD_IP: "3.110.204.162",
    BACKEND_PORT: 7777,
}
const BACKEND_URI = CONFIG.BACKEND_PROTOCOL + "://" +
    (CONFIG.BACKEND_ENV === "PROD" ? CONFIG.BACKEND_PROD_IP : CONFIG.BACKEND_LOCAL_IP) + ":" +
    CONFIG.BACKEND_PORT