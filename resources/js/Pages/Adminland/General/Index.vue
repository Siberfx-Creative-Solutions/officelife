<style lang="scss" scoped>
</style>

<template>
  <layout :notifications="notifications">
    <div class="ph2 ph0-ns">
      <!-- BREADCRUMB -->
      <div class="mt4-l mt1 mw6 br3 bg-white box center breadcrumb relative z-0 f6 pb2">
        <ul class="list ph0 tc-l tl">
          <li class="di">
            <inertia-link :href="'/' + $page.props.auth.company.id + '/dashboard'">{{ $t('app.breadcrumb_dashboard') }}</inertia-link>
          </li>
          <li class="di">
            <inertia-link :href="'/' + $page.props.auth.company.id + '/account'">{{ $t('app.breadcrumb_account_home') }}</inertia-link>
          </li>
          <li class="di">
            {{ $t('app.breadcrumb_account_manage_general_settings') }}
          </li>
        </ul>
      </div>

      <!-- BODY -->
      <div class="mw7 center br3 mb5 bg-white box restricted relative z-1">
        <div class="mt5">
          <h2 class="pa3 tc normal mb4">
            {{ $t('account.general_title') }}
          </h2>

          <!-- stats -->
          <stat
            :information="information"
          />

          <!-- company name -->
          <name
            :information="information"
          />

          <!-- company founded -->
          <founded-date
            :information="information"
          />

          <!-- company location -->
          <location
            :information="information"
          />

          <!-- Currency -->
          <currency
            :information="information"
            :currencies="currencies"
          />

          <!-- Logo -->
          <logo
            :information="information"
          />
        </div>
      </div>
    </div>
  </layout>
</template>

<script>
import Layout from '@/Shared/Layout';
import Name from '@/Pages/Adminland/General/Partials/Name';
import Currency from '@/Pages/Adminland/General/Partials/Currency';
import Stat from '@/Pages/Adminland/General/Partials/Stat';
import Location from '@/Pages/Adminland/General/Partials/Location';
import Logo from '@/Pages/Adminland/General/Partials/Logo';
import FoundedDate from '@/Pages/Adminland/General/Partials/FoundedDate';

export default {
  components: {
    Layout,
    Name,
    Location,
    Currency,
    Stat,
    Logo,
    FoundedDate,
  },

  props: {
    notifications: {
      type: Array,
      default: null,
    },
    information: {
      type: Object,
      default: null,
    },
    currencies: {
      type: Array,
      default: null,
    },
  },

  mounted() {
    if (localStorage.success) {
      this.flash(localStorage.success, 'success');

      localStorage.removeItem('success');
    }
  },
};

</script>
