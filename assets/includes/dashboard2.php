<?php
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>

<header class="header" id="header">
    <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i></div>
</header>
<div class="l-navbar" id="nav-bar">
    <nav class="nav">
        <div> 
            <a href="calendar.php" class="nav_logo"> 
                <i class='bx bx-spa nav_logo-icon'></i> 
                <span class="nav_logo-name">Dashboard SM SPA</span> 
            </a>
            <div class="nav_list"> 
                <a href="calendar.php" class="nav_link <?php echo ($current_page == 'calendar') ? 'active' : ''; ?>"> 
                    <i class='bx bxs-calendar nav_icon'></i> 
                    <span class="nav_name">Calendario</span> 
                </a> 
                <a href="history.php" class="nav_link <?php echo ($current_page == 'history') ? 'active' : ''; ?>"> 
                    <i class='bx bx-book-open nav_icon'></i> 
                    <span class="nav_name">Historial Reservas</span> 
                </a>
            </div>
        </div> 
        <a href="assets/includes/logout.php" class="nav_link"> 
            <i class='bx bx-log-out nav_icon'></i> 
            <span class="nav_name">Cerrar Sesión</span> 
        </a>
    </nav>
</div>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");

    :root {
        --header-height: 3rem;
        --nav-width: 68px;
        --first-color: black;
        --first-color-light: #AFA5D9;
        --white-color: #F7F6FB;
        --body-font: 'Nunito', sans-serif;
        --normal-font-size: 1rem;
        --z-fixed: 100
    }

    *,
    ::before,
    ::after {
        box-sizing: border-box
    }

    body {
        position: relative;
        margin: var(--header-height) 0 0 0;
        padding: 0 1rem;
        font-family: var(--body-font);
        font-size: var(--normal-font-size);

    }

    a {
        text-decoration: none
    }

    .header {
        width: 100%;
        height: var(--header-height);
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 1rem;
        background-color: #dedede;
        z-index: var(--z-fixed);
        transition: .5s
    }

    .header_toggle {
        color: black;
        font-size: 1.5rem;
        cursor: pointer
    }

    .header_img img {
        width: 40px
    }

    .l-navbar {
        position: fixed;
        top: 0;
        left: -30%;
        width: var(--nav-width);
        height: 100vh;
        background-color: var(--first-color);
        padding: .5rem 1rem 0 0;
        transition: .5s;
        z-index: var(--z-fixed)
    }

    .nav {
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: hidden
    }

    .nav_logo,
    .nav_link {
        display: grid;
        grid-template-columns: max-content max-content;
        align-items: center;
        column-gap: 1rem;
        padding: .5rem 0 .5rem 1.5rem
    }

    .nav_logo {
        margin-bottom: 2rem
    }

    .nav_logo-icon {
        font-size: 1.25rem;
        color: var(--white-color)
    }

    .nav_logo-name {
        color: var(--white-color);
        font-weight: 700
    }

    .nav_link {
        position: relative;
        color: var(--first-color-light);
        margin-bottom: 1.5rem;
        transition: .3s
    }

    .nav_link:hover {
        color: var(--white-color)
    }

    .nav_icon {
        font-size: 1.25rem
    }

    .navbar-show {
        left: 0
    }

    .body-pd {
        padding-left: calc(var(--nav-width) + 1rem)
    }

    .active {
        color: var(--white-color)
    }

    .active::before {
        content: '';
        position: absolute;
        left: 0;
        width: 2px;
        height: 32px;
        background-color: var(--white-color)
    }

    .height-100 {
        height: 100vh
    }

    @media screen and (min-width: 768px) {
        body {
            margin: calc(var(--header-height) + 1rem) 0 0 0;
            padding-left: calc(var(--nav-width) + 2rem)
        }

        .header {
            height: calc(var(--header-height) + 1rem);
            padding: 0 2rem 0 calc(var(--nav-width) + 2rem)
        }

        .l-navbar {
            left: 0;
            padding: 1rem 1rem 0 0
        }

        .navbar-show {
            width: calc(var(--nav-width) + 156px)
        }

        .body-pd {
            padding-left: calc(var(--nav-width) + 188px)
        }
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        const showNavbar = (toggleId, navId, bodyId, headerId) => {
            const toggle = document.getElementById(toggleId),
                nav = document.getElementById(navId),
                bodypd = document.getElementById(bodyId),
                headerpd = document.getElementById(headerId);

            // Validate that all variables exist
            if (toggle && nav && bodypd && headerpd) {
                toggle.addEventListener("click", () => {

                    nav.classList.toggle("navbar-show");
                    toggle.classList.toggle("bx-x");
                    bodypd.classList.toggle("body-pd");
                    headerpd.classList.toggle("body-pd");
                });
            }
        };

        const links = document.querySelectorAll(".nav_link");

        links.forEach((link) => {
            link.addEventListener("click", () => {
                links.forEach((otherLink) => {
                    otherLink.classList.remove("active");
                });
                link.classList.add("active");
            });
        });

        showNavbar("header-toggle", "nav-bar", "body-pd", "header");
    });
</script>