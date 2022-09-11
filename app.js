$(document).ready(function () {
  $("#archive_lisnyctwa_search_name").on("input", function () {
    if ($(this).val() != "") {
      let searchText = $(this).val().toLowerCase();
      $(".archive_lisnyctwa_item__title").each(function () {
        let text = $(this).text();
        console.log(text);
        if (text.toLowerCase().indexOf(searchText) >= 0) {
          $(this).parent().css("display", "block");
        } else {
          $(this).parent().css("display", "none");
        }
      });
    } else {
      $(".archive_lisnyctwa_item").css("display", "block");
    }
  });

  $(".accordeon .accordeon_content").hide();
  $(".accordeon__main").on("click", function () {
    if ($(this).parent().hasClass("active")) {
      $(this).parent().find(".accordeon_content").slideUp();
      $(this).parent().removeClass("active");
    } else {
      $(this).parent().addClass("active");
      $(this).parent().find(".accordeon_content").slideDown();
    }
  });

  $("#login_form").submit(function (e) {
    e.preventDefault();

    var data = {
      username: $(this).find('input[name="uname"').val(),
      password: $(this).find('input[name="upassword"').val(),
    };

    $.ajax({
      type: "post",
      url: $(this).attr("action"),
      data: data,
      success: function (response) {
        if (response != "" && response != "redirect") {
          $(".form_error_wrapp").text(response).addClass("show");
        } else if (response == "redirect") {
          window.location.replace("front-page.php");
        }
      },
    });
  });
});
