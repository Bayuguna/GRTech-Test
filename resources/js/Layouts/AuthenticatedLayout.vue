<script setup>
import { onMounted, ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import { Link } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
const user_access = ref([]);

const fetchUserAccess = async () => {
    try {
        const response = await axios.get(route("user_access"));
        user_access.value = response.data;
    } catch (error) {
        console.error("Error fetching accesses:", error);
    }
};

onMounted(fetchUserAccess);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="border-b border-gray-100 bg-white">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>
                        </div>

                        <!-- Navigation Links -->
                        <!-- {{ user_access }} -->
                        <div
                            class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                        >
                            <li
                                v-for="menu in $page.props.menu"
                                :key="menu.id"
                                class="flex items-center"
                            >
                                <!-- If Menu Doesn't Have SubMenu -->
                                <div
                                    v-if="!menu.submenus"
                                    :hidden="
                                        menu.can
                                            ? !user_access.some((a) =>
                                                  menu.can.includes(a)
                                              )
                                            : false
                                    "
                                >
                                    <NavLink
                                        :href="menu.url"
                                        :active="
                                            menu.active.some((a) =>
                                                route().current(a)
                                            )
                                        "
                                    >
                                        {{ menu.text }}
                                    </NavLink>
                                </div>

                                <!-- If Menu Have SubMenu -->
                                <div
                                    v-if="menu.submenus"
                                    :hidden="
                                        menu.can
                                            ? !user_access.some((a) =>
                                                  menu.can.includes(a)
                                              )
                                            : false
                                    "
                                >
                                    <a-dropdown>
                                        <a
                                            :class="
                                                menu.active.some((a) =>
                                                    route().current(a)
                                                )
                                                    ? 'inline-flex items-center px-1 pt-1 border-b-2 border-success-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-success-700 transition duration-150 ease-in-out'
                                                    : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
                                            "
                                            @click.prevent
                                        >
                                            {{ menu.text }}
                                            <svg
                                                class="-me-0.5 ms-2 h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        </a>
                                        <template #overlay>
                                            <a-menu class="min-w-40">
                                                <a-menu-item
                                                    v-for="submenu in menu.submenus"
                                                    :key="submenu.id"
                                                >
                                                    <a
                                                        :href="submenu.url"
                                                        :class="
                                                            submenu.active.some(
                                                                (a) =>
                                                                    route().current(
                                                                        a
                                                                    )
                                                            )
                                                                ? '!text-success-700'
                                                                : '!text-gray-900'
                                                        "
                                                    >
                                                        {{ submenu.text }}
                                                    </a>
                                                </a-menu-item>
                                                <!-- <a-menu-divider />
                                                    <a-menu-item
                                                        key="3"
                                                        disabled
                                                        >3rd menu
                                                        item（disabled）</a-menu-item
                                                    > -->
                                            </a-menu>
                                        </template>
                                    </a-dropdown>
                                </div>
                            </li>
                            <!-- <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Dashboard
                                </NavLink> -->
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <!-- Settings Dropdown -->
                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span
                                            class="inline-flex rounded-md gap-2 items-center"
                                        >
                                            <div
                                                class="flex flex-col items-end text-xs"
                                            >
                                                <span class="font-semibold">{{
                                                    $page.props.auth.user.name
                                                }}</span>
                                                <span class="font-extralight">{{
                                                    $page.props.auth.user.email
                                                }}</span>
                                            </div>
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                            >
                                                <div
                                                    class="bg-neutral-300 rounded-full p-[3px] flex items-center justify-center"
                                                >
                                                    <div
                                                        class="bg-success-700 text-neutral-100 rounded-full w-8 h-8 flex items-center justify-center"
                                                    >
                                                        {{
                                                            $page.props.auth
                                                                .user.name[0]
                                                        }}
                                                    </div>
                                                </div>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                        >
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="border-t border-gray-200 pb-1 pt-4">
                        <div class="px-4">
                            <div class="text-base font-medium text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')">
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
