<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Auto-login Feature</h3>
            <p class="mb-4 text-gray-700 dark:text-gray-300">
                If your blockchain information displays below, you're automatically logged in to WaxJS, and you don't need to click WAX Login. This eliminates the need for multiple clicks and popups!
            </p>
            <p class="text-indigo-600 mb-6" id="autologin"></p>

            <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">WAX Login</h3>
            <p class="mb-4 text-gray-700 dark:text-gray-300">
                Use this if you're not automatically logged in. Note that if you are auto-logged in, clicking this does not open a popup and the userAccount is still returned.
            </p>
            <x-secondary-button class="ms-3" id="login" onclick=login()>WAX Login</x-secondary-button>
            <p class="text-indigo-600 mt-4" id="loginresponse"></p>
        </div>
    </div>

    <script src="waxjs.js"></script>
    <script>
        const wax = new waxjs.WaxJS({
            rpcEndpoint: 'https://wax.greymass.com',
            // userAccount: '',
            // pubKeys: [
            // ],
        });

        //automatically check for credentials
        autoLogin();

        //checks if autologin is available
        async function autoLogin() {
            let isAutoLoginAvailable = await wax.isAutoLoginAvailable();
            if (isAutoLoginAvailable) {
                let userAccount = wax.userAccount;
                let pubKeys = wax.pubKeys;
                let str = 'AutoLogin enabled for account: ' + userAccount + '<br/>Active: ' + pubKeys[0] + '<br/>Owner: ' + pubKeys[1]
                document.getElementById('autologin').insertAdjacentHTML('beforeend', str);
            } else {
                document.getElementById('autologin').insertAdjacentHTML('beforeend', 'Not auto-logged in');
            }
        }

        //normal login. Triggers a popup for non-whitelisted dapps
        async function login() {
            try {
                //if autologged in, this simply returns the userAccount w/no popup
                let userAccount = await wax.login();
                let pubKeys = wax.pubKeys;
                let str = 'Account: ' + userAccount + '<br/>Active: ' + pubKeys[0] + '<br/>Owner: ' + pubKeys[1]
                document.getElementById('loginresponse').insertAdjacentHTML('beforeend', str);
            } catch (e) {
                document.getElementById('loginresponse').append(e.message);
            }
        }
    </script>
</x-app-layout>
