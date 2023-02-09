(function () {

    $("#student_cnt").on("change", function () {
        var selectCnt = $(this).val();
        for (let i=1; i <=6; i++)
        {
          let className = ".students" + i;
          console.log(className)
          if (i <= selectCnt)
          {
            console.log("AA")
            $(className).removeClass("hide");
          }
          else
          {
            $(className).addClass("hide"); 
          }
        }
    })
  })();
  