$(document).ready(function () {
  // Hàm kiểm tra session
  function checkUserSession() {
    return $.ajax({
      url: "../../API/api_check_session.php",
      type: "GET",
      cache: false, // Không cache để luôn kiểm tra mới
      xhrFields: { withCredentials: true },
      timeout: 5000, // Timeout 5 giây
    });
  }

  // Hàm chuyển về login
  function redirectToLogin(message = "Phiên đăng nhập đã hết hạn!") {
    alert(message);
    window.location.replace("login_canBo.html");
  }

  // Kiểm tra session trước khi load dữ liệu
  console.log("Checking user session...");

  checkUserSession()
    .done(function (response) {
      console.log("Session check response:", response);

      if (response.status === "success") {
        console.log("Session valid, page can continue loading...");

        // Trigger custom event để các trang khác biết session hợp lệ
        $(document).trigger("sessionValid", [response]);

        // Cập nhật tên user trên topbar nếu có
        if (response.user_id) {
          $(".text-gray-600.small").text("User " + response.user_id);
        }
      } else {
        console.log("Session invalid:", response.message);
        redirectToLogin(response.message);
      }
    })
    .fail(function (xhr, status, error) {
      console.error("Session check failed:", { xhr, status, error });

      if (xhr.status === 401) {
        redirectToLogin("Phiên đăng nhập đã hết hạn!");
      } else {
        redirectToLogin(
          "Không thể kiểm tra phiên đăng nhập. Vui lòng đăng nhập lại!"
        );
      }
    });

  // Kiểm tra session khi user quay lại trang (từ back button)
  window.addEventListener("pageshow", function (event) {
    if (event.persisted) {
      console.log("Page loaded from cache, rechecking session...");
      checkUserSession().fail(function () {
        redirectToLogin("Vui lòng đăng nhập lại!");
      });
    }
  });

  // Expose functions để các trang khác có thể sử dụng
  window.sessionChecker = {
    check: checkUserSession,
    redirectToLogin: redirectToLogin,
  };
});
