   <!-- End Main -->

    <footer>

      <p>Copyrigt@2017</p>

    </footer>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

    <script src="/assets/js/jquery.min.js"></script>

    <!-- Include all compiled plugins (below), or include individual files as needed -->

    <script src="/assets/js/bootstrap.min.js"></script>

    <script src="/assets/js/cart.js"></script>
    <script src="/assets/js/check_browser.js"></script>

    <script type="text/javascript">

  

      $(document).ready(function() {

        detectBrowserClose();

        $('.sidebar-collapse').click(function(e){

          e.preventDefault();

          $('.main').toggleClass('collapsed');



          $(this).toggleClass('hide-sidebar');

        });



        $(".collapse a").click(function(event) {

          $(event.target).closest(".collapse").addClass("current");

        });



      });

    </script>

  </body>

</html>