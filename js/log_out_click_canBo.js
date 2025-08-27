function confirmLogout() {
  console.log("confirmLogout called, Swal type:", typeof Swal);

  // Kiểm tra SweetAlert2
  if (typeof Swal === "undefined") {
    console.error("SweetAlert2 not loaded!");
    // Fallback với confirm
    if (confirm("Bạn có chắc muốn đăng xuất?")) {
      doLogout();
    }
    return;
  }

  Swal.fire({
    title: "Bạn có chắc muốn đăng xuất?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Đăng xuất",
    cancelButtonText: "Hủy",
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
  }).then((result) => {
    document.activeElement.blur();

    if (result.isConfirmed) {
      doLogout();
    }
  });
}

// Tách riêng logic logout
function doLogout() {
  console.log("Starting logout process...");

  fetch("../../API/api_logout.php", {
    method: "POST",
    credentials: "include",
  })
    .then((response) => {
      console.log("Logout response status:", response.status);
      return response.json();
    })
    .then((data) => {
      console.log("Logout response data:", data);
    })
    .catch((error) => {
      console.log("Logout error:", error);
    })
    .finally(() => {
      console.log("Cleaning up and redirecting...");
      // Xóa dữ liệu client
      localStorage.clear();
      sessionStorage.clear();

      // Chuyển trang
      window.location.replace("login_canBo.html");
    });
}

// Test function
// function testLogoutFunction() {
//   console.log("=== LOGOUT FUNCTION TEST ===");
//   console.log("confirmLogout exists:", typeof confirmLogout === "function");
//   console.log("Swal exists:", typeof Swal !== "undefined");
//   console.log("Current URL:", window.location.href);
// }
