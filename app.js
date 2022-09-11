$(document).ready(function () {
  $("#archive_lisnyctwa_search_name").on("input", function () {
    if ($(this).val() != "") {
      let searchText = $(this).val().toLowerCase();
      $(".archive_lisnyctwa_item__title").each(function () {
        let text = $(this).text();
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

  $("#create_ticket_form").submit(function (e) {
    e.preventDefault();
    let hasError = false;

    $(".create_ticket__submit").text("Виконується...");

    $("#create_ticket_form input").each(function () {
      if (
        ($(this).attr("name") != "func_name" &&
          $.isNumeric($(this).val()) == false) ||
        $(this).val() == ""
      ) {
        alert(
          "В поле був поданий невірний знак, або поле залишене пустим. Можна використовувати тільки цифри від 0 до 9 і крапку."
        );
        $(this).addClass("input_with_error");
        $(this).keyup(function () {
          if ($.isNumeric($(this).val())) {
            $(this).removeClass("input_with_error");
            $(this).off("keyup");
          }
        });
        hasError = true;
        $(".create_ticket__submit").text("Підтвердити");
      }
    });

    if (!hasError) {
      var filter = $("#create_ticket_form");
      var formData = filter.serialize();

      $.ajax({
        type: "post",
        url: $(this).attr("action"),
        data: formData,
        success: function (response) {
          $(".create_ticket__submit").text("Підтвердити");
          alert("Квиток успішно створений");
          $("#create_ticket_form .create_ticket_data_wrapper input").val(0);
          let nextval =
            Number(
              $(
                "#create_ticket_form .create_ticket_form_block--ticket_number input"
              ).val()
            ) + 1;
          $(
            "#create_ticket_form .create_ticket_form_block--ticket_number input"
          ).val(nextval);
        },
      });
    }
  });
});
