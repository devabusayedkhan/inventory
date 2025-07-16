<div class="flex items-center gap-3 justify-between md:justify-start m-4" id="menuToggle">
  <span class="hidden md:block" onclick="dashbordLeftContent()">
    <div class="mobile-menu">
      <span class="line-1"></span>
      <span class="line-2"></span>
      <span class="line-3"></span>
    </div>
  </span>
  <a href="/dashboard" class="text-lg font-bold text-cyan-700 border-2 px-3 py-1 rounded">
    <i class="fa-solid fa-chart-line"></i>
    Dashbord
  </a>
  <button class="text-2xl menueTogglebtn block md:hidden"></button>
</div>




<!-- menue icon  -->
<script>
  const mobileMenu = document.querySelector(".mobile-menu");
  const mobileMenuItem = document.querySelector(".mobile-menu-item");
  const line1 = document.querySelector(".mobile-menu .line-1");
  const line2 = document.querySelector(".mobile-menu .line-2");
  const line3 = document.querySelector(".mobile-menu .line-3");
  //line 1 css
  line1.style.top = "50%";
  line1.style.transform = "rotate(-45deg)";
  //line 2 css
  line2.style.opacity = "0";
  //line 3 css
  line3.style.top = "50%";
  line3.style.transform = "rotate(45deg)";

  mobileMenu.onclick = () => {
    if (line2.style.opacity !== "0") {
      //line 1 css
      line1.style.top = "50%";
      line1.style.transform = "rotate(-45deg)";
      //line 2 css
      line2.style.opacity = "0";
      //line 3 css
      line3.style.top = "50%";
      line3.style.transform = "rotate(45deg)";

    } else {
      line2.style.opacity = "1"
      //line 1 css
      line1.style.top = "22%";
      line1.style.transform = "rotate(0deg)";
      //line 2 css
      line2.style.opacity = "1";
      //line 3 css
      line3.style.top = "78%";
      line3.style.transform = "rotate(0deg)";

    }
  };
</script>