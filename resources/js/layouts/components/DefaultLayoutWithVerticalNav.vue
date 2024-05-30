<script setup>
import VerticalNavLayout from '@layouts/components/VerticalNavLayout.vue';
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue';

const user = JSON.parse(localStorage.getItem('user'))
const isAdmin = user.roles === 'admin'
</script>

<template>
  <VerticalNavLayout>
    <template #vertical-nav-content>
      <div v-if="isAdmin">
        <VerticalNavLink
          :item="{
            title: 'Dashboard',
            icon: 'material-symbols:dashboard',
            to: `/dashboard/${user.roles}`,
          }"
        />
      </div>
      <div v-if="isAdmin">
        <VerticalNavLink
          :item="{
            title: 'Modules',
            icon: 'ph:circles-three',
            to: '/modules-list',
          }"
        />
      </div>
      <div v-if="!isAdmin">
        <VerticalNavLink
          :item="{
            title: 'Modules',
            icon: 'ph:circles-three',
            to: '/modules-view/1',
          }"
        />
      </div>

      <div v-if="isAdmin">
        <VerticalNavLink
          :item="{
            title: 'Employees',
            icon: 'clarity:employee-group-line',
            to: '/employees-list',
          }"
        />
      </div>
      <div v-if="!isAdmin">
        <VerticalNavLink
          :item="{
            title: 'Feedback',
            icon: 'fluent-mdl2:feedback-response-solid',
            to: '/feedback-form',
          }"
        />
      </div>
      <div v-if="isAdmin">
        <VerticalNavLink
          :item="{
            title: 'Feedback',
            icon: 'fluent-mdl2:feedback-response-solid',
            to: '/feedback-list',
          }"
        />
      </div>
     

      <VerticalNavLink
        :item="{
          title: 'Logout',
          icon: 'material-symbols:logout',
          to: '/logout',
        }"
      />
    </template>

    <!-- 👉 Pages -->
    <slot />
  </VerticalNavLayout>
</template>

