$(document).ready(function () {
  $("select").each(function () {
    let selectVal = $(this).val();
  });

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
          $(this).attr("name") != "table_name" &&
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
          if (response.includes("data_added")) {
            alert("Данні успішно додані");
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
          } else if (response.includes("ticket_added")) {
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
          } else if (response.includes("already_exists")) {
            alert("Квиток для цієї рубки вже існує");
          }
        },
      });
    }
  });

  let rubky = [];
  if ($("#rubky").length) {
    $("#rubky .rubka").each(function () {
      rubky.push([
        $(this).find(".rubka_kv").text(),
        $(this).find(".rubka_vy").text(),
      ]);
    });
  }
  $(".filter_kvartals").on("change", function () {
    $(".row-data").removeClass("hidden-row");
    $(".row-data").removeClass("hidden-row-imp");
    $(".filter_vydils option").remove();
    if ($(this).val() != "") {
      let value = $(this).val();
      $(".filter_vydils").append(`<option value="">Виділ...</option>`);
      $(".filter_vydils").removeClass("hidden");
      $(".row-data").each(function () {
        if ($(this).data("kwartal") != value) {
          $(this).addClass("hidden-row");
        }
      });
      rubky.forEach((rubka) => {
        if (rubka[0] == $(this).val()) {
          $(".filter_vydils").append(
            `<option value="${rubka[1]}">${rubka[1]}</option>`
          );
        }
      });
    } else {
      $(".filter_vydils").addClass("hidden");
      $(".filter_vydils option").removeClass("hidden_option");
    }
  });
  $(".filter_vydils").on("change", function () {
    $(".row-data").removeClass("hidden-row-imp");
    if ($(this).val() != "") {
      let value = $(this).val();
      $(".row-data").each(function () {
        if ($(this).data("vydil") != value) {
          $(this).addClass("hidden-row-imp");
        }
      });
    }
  });

  /*RUBKA SUM*/
  let tables = $(".accordeon__table table.data_table");
  tables.each(function () {
    let rows = $(this).find(".row-data_js");
    let table = $(this);
    let sums = [];
    let kvartal = 0,
      vydil = 0;
    let prevKvartal = null,
      prevVydil = null;
    console.log("new table");
    rows.each(function (index) {
      let cells = $(this).find("td");
      console.log(cells);
      kvartal = $(this).data("kwartal");
      vydil = $(this).data("vydil");
      if (prevKvartal === null) {
        prevKvartal = kvartal;
        console.log("Hey its traitor");
      }
      if (prevVydil === null) {
        prevVydil = vydil;
      }
      console.log(kvartal);
      console.log(prevKvartal);
      console.log(vydil);
      console.log(prevVydil);
      if (kvartal == prevKvartal && vydil == prevVydil) {
        cells.each(function (index) {
          if (sums[index]) {
            let val = $(this).text();
            sums[index] = sums[index] + parseFloat(val);
            sums[index] = sums[index].toFixed(3);
          } else {
            sums[index] = parseFloat($(this).text());
          }
        });
        console.log(sums);
      } else {
        sums.forEach((element, index) => {
          if (index >= 2) {
            table
              .find(
                ".total_row.row-data[data-kwartal=" +
                  prevKvartal +
                  "][data-vydil=" +
                  prevVydil +
                  "]"
              )
              .append("<td>" + element + "</td>");
          }
        });
        sums = [];
        cells.each(function (index) {
          if (sums[index]) {
            let val = $(this).text();
            sums[index] = sums[index] + parseFloat(val);
            sums[index] = sums[index].toFixed(3);
          } else {
            sums[index] = parseFloat($(this).text());
          }
        });
        console.log(sums);
      }
      prevKvartal = kvartal;
      prevVydil = vydil;
    });
    sums.forEach((element, index) => {
      if (index >= 2) {
        table
          .find(
            ".total_row.row-data[data-kwartal=" +
              prevKvartal +
              "][data-vydil=" +
              prevVydil +
              "]"
          )
          .append("<td>" + element + "</td>");
      }
    });
  });
});
