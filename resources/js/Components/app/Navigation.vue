<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import CreateNewDropdown from "./CreateNewDropdown.vue";
import NavLink from "@/Components/NavLink.vue";
</script>
<template>
    <nav class="min-w-[100px]">
        <div class="h-[80px] px-3 flex items-center gap-3">
            <Link href="/">
       
                        <ApplicationLogo
                            class="block h-9 w-auto fill-current text-gray-800"
                        />
             laraStorage
            </Link>
        </div>
        <div class="px-3">
            <CreateNewDropdown/>
            <div class="py-3">
                <NavLink href="/"> My Files</NavLink>
                <NavLink href="/" >Shared With Me</NavLink>
                <NavLink href="/">Sharted By Me</NavLink>
                <NavLink href="/">Trash</NavLink>
               
            </div>
        </div>
    </nav>
</template>
