const CONFIG = {
    BACKEND_ENV: "LOCAL", //"PROD" for Production backend and "local" for local backend

    BACKEND_LOCAL_IP: "localhost:7777",
    BACKEND_QA_IP: "qa.bsquaresupermart.in",
    BACKEND_PROD_IP: "www.bsquaresupermart.in"
}

let BACKEND_URI = null;
if(CONFIG.BACKEND_ENV === "LOCAL"){
    BACKEND_URI = "http://" + CONFIG.BACKEND_LOCAL_IP;
}else if(CONFIG.BACKEND_ENV === "QA"){
    BACKEND_URI = "https://" + CONFIG.BACKEND_QA_IP + "/api";
}else if(CONFIG.BACKEND_ENV === "PROD"){
    BACKEND_URI = "https://" + CONFIG.BACKEND_PROD_IP + "/api";
}