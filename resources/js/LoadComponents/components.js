Vue.mixin(require('./trans.js'));
Vue.component('success-error-msg', require('../components/SuccessErrorMsg.vue').default);
Vue.component('image-comp', require('../components/ImageComponent/ImageComp.vue').default);
Vue.component('advance-image-comp', require('../components/ImageComponent/AdvanceImageComp.vue').default);
Vue.component('show-image-comp', require('../components/ImageComponent/ShowImageComp.vue').default);
Vue.component('show-image-comp-v2', require('../components/ImageComponent/ShowImageCompV2.vue').default);

Vue.component('gallery-comp', require('../components/ImageComponent/GalleryComp.vue').default);

Vue.component('login-comp', require('../components/admin/auth/LoginComp.vue').default);
Vue.component('show-profile-comp', require('../components/admin/profile/ShowProfileComp.vue').default);
Vue.component('update-profile-comp', require('../components/admin/profile/UpdateProfileComp.vue').default);

Vue.component('option-comp', require('../components/OptionComp.vue').default);

// const files = require.context('../components/admin', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
