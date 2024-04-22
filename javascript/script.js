const showPwdBtn = document.getElementById("show-pwd");
const pwd = document.getElementById("pwd");
const conf_pwd = document.getElementById("conf_pwd");

showPwdBtn.addEventListener("click", () => {
  if (pwd.type === "text" && conf_pwd.type === "text") {
    pwd.type = "password";
    conf_pwd.type = "password";
  } else {
    pwd.type = "text";
    conf_pwd.type = "text";
  }
});
