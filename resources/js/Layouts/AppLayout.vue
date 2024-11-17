<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="min-vh-100 bg-light">
            <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
                <div class="container">
                    <!-- Logo -->
                    <Link :href="route('dashboard')" class="navbar-brand">
                        <ApplicationMark style="height: 2.25rem;" />
                    </Link>

                    <!-- Hamburger -->
                    <button class="navbar-toggler" type="button" @click="showingNavigationDropdown = !showingNavigationDropdown">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Navigation -->
                    <div class="collapse navbar-collapse" :class="{ 'show': showingNavigationDropdown }">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <NavLink :href="route('dashboard')" :active="route().current('dashboard')" class="nav-link">
                                    Dashboard
                                </NavLink>
                            </li>
                        </ul>

                        <!-- Teams Dropdown -->
                        <div class="d-flex align-items-center">
                            <Dropdown v-if="$page.props.jetstream.hasTeamFeatures" align="right" width="60">
                                <template #trigger>
                                    <button type="button" class="btn btn-light dropdown-toggle d-flex align-items-center">
                                        {{ $page.props.auth.user.current_team.name }}
                                    </button>
                                </template>

                                <template #content>
                                    <div style="width: 15rem;">
                                        <div class="dropdown-header">Manage Team</div>

                                        <DropdownLink :href="route('teams.show', $page.props.auth.user.current_team)" class="dropdown-item">
                                            Team Settings
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.canCreateTeams" :href="route('teams.create')" class="dropdown-item">
                                            Create New Team
                                        </DropdownLink>

                                        <!-- Team Switcher -->
                                        <template v-if="$page.props.auth.user.all_teams.length > 1">
                                            <div class="dropdown-divider"></div>
                                            <div class="dropdown-header">Switch Teams</div>

                                            <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                                <form @submit.prevent="switchToTeam(team)">
                                                    <DropdownLink as="button" class="dropdown-item">
                                                        <div class="d-flex align-items-center">
                                                            <svg v-if="team.id == $page.props.auth.user.current_team_id" class="me-2" style="height: 1.25rem; width: 1.25rem;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            <div>{{ team.name }}</div>
                                                        </div>
                                                    </DropdownLink>
                                                </form>
                                            </template>
                                        </template>
                                    </div>
                                </template>
                            </Dropdown>

                            <!-- Settings Dropdown -->
                            <Dropdown align="right" width="48" class="ms-3">
                                <template #trigger>
                                    <button v-if="$page.props.jetstream.managesProfilePhotos" class="btn btn-light p-0">
                                        <img class="rounded-circle" style="height: 2rem; width: 2rem; object-fit: cover;" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                                    </button>

                                    <button v-else type="button" class="btn btn-light dropdown-toggle d-flex align-items-center">
                                        {{ $page.props.auth.user.name }} ({{ $page.props.auth.user.email }})
                                    </button>
                                </template>

                                <template #content>
                                    <div class="dropdown-header">Manage Account</div>

                                    <DropdownLink :href="route('profile.show')" class="dropdown-item">
                                        Profile
                                    </DropdownLink>

                                    <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')" class="dropdown-item">
                                        API Tokens
                                    </DropdownLink>

                                    <div class="dropdown-divider"></div>

                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button" class="dropdown-item">
                                            Log Out
                                        </DropdownLink>
                                    </form>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow-sm">
                <div class="container py-3">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="py-4">
                <slot />
            </main>
        </div>
    </div>
</template>
