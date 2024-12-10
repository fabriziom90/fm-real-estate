<script setup></script>
<template lang="">
    <div class="sidenav">
        <ul class="list-none">
            <li
                class="my-3 py-3 ps-2 border-s-4 border-white hover:border-s-4 hover:border-main-blue"
            >
                <a :href="route('profile.edit')" class="hover:text-main-blue">
                    <div class="flex justify-between items-center">
                        <span class="display-hover">
                            <i class="fas fa-user me-2"></i>
                            <span> Profilo </span>
                        </span>
                        <span class="hidden-hover">
                            <i class="fas fa-user"></i>
                        </span>
                    </div>
                </a>
            </li>
            <li
                class="my-3 py-3 ps-2 border-s-4 border-white hover:border-s-4 hover:border-main-blue"
            >
                <a
                    :href="route('logout')"
                    class="hover:text-main-blue"
                    method="post"
                    as="button"
                >
                    <div class="flex justify-between items-center">
                        <span class="display-hover">
                            <i
                                class="fas fa-solid fa-arrow-right-from-bracket me-2"
                            ></i>
                            <span> Logout </span>
                        </span>
                        <span class="hidden-hover">
                            <i
                                class="fas fa-solid fa-arrow-right-from-bracket"
                            ></i>
                        </span>
                    </div>
                </a>
            </li>
        </ul>
    </div>
</template>
<style lang="css">
.sidenav {
    width: 175px;
    background-color: #fff;
    position: fixed;
    padding: 20px;
    top: 40%;
    left: -110px;
    border-radius: 0px 20px 20px 0px;
    border-width: 1px 1px 1px 0px;
    border-color: #000;
    z-index: 1;
    transition: 0.3s;
}

.sidenav:hover {
    left: 0px;
}

.sidenav:hover .display-hover {
    display: none;
}

.sidenav:hover .hidden-hover {
    display: none;
}

.sidenav:hover .display-hover {
    display: block;
}
</style>
