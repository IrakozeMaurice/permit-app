      <!-- Footer -->
      <footer style="padding:4px 2px;" class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
            <div class="text-center text-sm text-gray-500 sm:text-left">
              <div class="flex items-center">
                <span>Made with</span>
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  viewBox="0 0 24 24" class="ml-4 -mt-px w-5 h-5 text-gray-400">
                  <path
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                  </path>
                </svg>
                <span>&nbsp;&nbsp;&nbsp;&nbsp;By&nbsp;</span>
                <a href="https://github.com" class="ml-1 underline">
                  Steven MUGARA
                </a>
              </div>
            </div>
            <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
              Auca@2022
            </div>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <!-- <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script> -->
  <script type="application/javascript" src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- Core plugin JavaScript-->
  <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>
  <!-- Custom scripts for all pages-->
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
  <script type="application/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
  <script type="application/javascript" src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
  <script type="application/javascript">
      $(document).ready(function() {
          // $.noConflict();
          $('#tableSearch').DataTable();

          $(".clickable-row").click(function(){
            if($(this).hasClass("highlight"))
              $(this).removeClass('highlight');
            else
              $(this).addClass('highlight').siblings().removeClass('highlight');
            })

      });
  </script>
</body>

</html>
