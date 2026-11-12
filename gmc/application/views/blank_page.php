<?php
$this_page='auction';
include("include/header1.php");
?>
<div class="page-content-wrapper">
  <div class="page-content">

    <div class="row">
      <div class="col-md-12">
        <div class="col-md-6">
          <div class="form-group">
            <label class="control-label col-md-2">Auto <span class="required"> * </span></label>
            <div class="col-md-7">
              <input type="text" name="auto" id="auto" autocomplete="off" class="form-control" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include("include/footer1.php");
?>

<script>
  $( function() {
    var availableTags = [
    "ActionScript",
    "AppleScript",
    "Asp",
    "BASIC",
    "C",
    "C++",
    "Clojure",
    "COBOL",
    "ColdFusion",
    "Erlang",
    "Fortran",
    "Groovy",
    "Haskell",
    "Java",
    "JavaScript",
    "Lisp",
    "Perl",
    "PHP",
    "Python",
    "Ruby",
    "Scala",
    "Scheme"
    ];
    $( "#auto" ).autocomplete({
      source: availableTags
    });
  });
</script>