import { Http } from '../../src/js/http.module.js';

class UserSupport extends Http {
    constructor() {
        super();
    }
    getUsers(data, callback) {
        return this.call('../../app/application/get_users.php', data, callback);
    }
    getAdministrators(data, callback) {
        return this.call('../../app/application/get_administrators.php', data, callback);
    }
    getAdministrator(data, callback) {
        return this.call('../../app/application/get_administrator.php', data, callback);
    }
    deleteUser(data, callback) {
        return this.call('../../app/application/delete_user.php', data, callback);
    }
    updatePlan(data, callback) {
        return this.call('../../app/application/update_plan.php', data, callback);
    }
    addDeposit(data, callback) {
        return this.call('../../app/application/add_deposit.php', data, callback);
    }
    addDeposit(data, callback) {
        return this.call('../../app/application/add_deposit.php', data, callback);
    }
    deleteDeposit(data, callback) {
        return this.call('../../app/application/delete_deposit.php', data, callback);
    }
    reactiveDeposit(data, callback) {
        return this.call('../../app/application/reactive_deposit.php', data, callback);
    }
    deleteTransaction(data, callback) {
        return this.call('../../app/application/delete_transaction.php', data, callback);
    }
    getDeposits(data, callback) {
        return this.call('../../app/application/get_deposits.php', data, callback);
    }
    getTransactionsList(data, callback) {
        return this.call('../../app/application/get_transactions_list.php', data, callback);
    }
    disperseGains(data, callback) {
        return this.call('../../app/cronjob/disperse_gains.php', data, callback);
    }
    getInBackoffice(data, callback) {
        return this.call('../../app/application/get_in_backoffice.php', data, callback);
    }
    getStats(data, callback) {
        return this.call('../../app/application/get_stats.php', data, callback);
    }
    addCapitalToBroker(data, callback) {
        return this.call('../../app/application/add_capital_to_broker.php', data, callback);
    }
    addGainPerBroker(data, callback) {
        return this.call('../../app/application/add_gain_per_broker.php', data, callback);
    }
    saveBroker(data, callback) {
        return this.call('../../app/application/save_broker.php', data, callback);
    }
    getBrokerCapitals(data, callback) {
        return this.call('../../app/application/get_broker_capitals.php', data, callback);
    }
    addPerformance(data, callback) {
        return this.call('../../app/application/add_performance.php', data, callback);
    }
    deleteDeposit(data, callback) {
        return this.call('../../app/application/delete_deposit.php', data, callback, null, null, 'POST');
    }
    viewDeposit(data, callback) {
        return this.call('../../app/application/view_deposit.php', data, callback, null, null, 'POST');
    }
    closeOperation(data, callback) {
        return this.call('../../app/application/close_operation.php', data, callback, null, null, 'POST');
    }
    deleteCapital(data, callback) {
        return this.call('../../app/application/delete_capital.php', data, callback);
    }
    updateBroker(data, callback) {
        return this.call('../../app/application/update_broker.php', data, callback);
    }
    applyWithdraw(data, callback) {
        return this.call('../../app/application/apply_withdraw.php', data, callback);
    }
    applyDeposit(data, callback) {
        return this.call('../../app/application/apply_deposit.php', data, callback);
    }
    getBrokersData(data, callback) {
        return this.call('../../app/application/get_brokers_data.php', data, callback);
    }
    deleteWithdraw(data, callback) {
        return this.call('../../app/application/delete_withdraw.php', data, callback);
    }
    getUsersTransactions(data, callback) {
        return this.call('../../app/application/get_users_transactions.php', data, callback);
    }
    saveUser(data, callback) {
        return this.call('../../app/application/save_user.php', data, callback);
    }
    getAdministratorPermissions(data, callback) {
        return this.call('../../app/application/get_administrator_permissions.php', data, callback);
    }
    saveAdministrator(data, callback) {
        return this.call('../../app/application/save_administrator.php', data, callback);
    }
    editAdministrator(data, callback) {
        return this.call('../../app/application/edit_administrator.php', data, callback, null, null, 'POST');
    }
    getReferral(data, callback) {
        return this.call('../../app/application/get_referral.php', data, callback);
    }
    getCountries(data, callback) {
        return this.call('../../app/application/get_countries.php', data, callback);
    }
    inactiveBroker(data, callback) {
        return this.call('../../app/application/inactive_broker.php', data, callback);
    }
    deleteBroker(data, callback) {
        return this.call('../../app/application/delete_broker.php', data, callback);
    }
    activeBroker(data, callback) {
        return this.call('../../app/application/active_broker.php', data, callback);
    }
    getBrokers(data, callback) {
        return this.call('../../app/application/get_brokers.php', data, callback);
    }
    getBroker(data, callback) {
        return this.call('../../app/application/get_broker.php', data, callback);
    }
    getUser(data, callback) {
        return this.call('../../app/application/get_user.php', data, callback);
    }
    updateUser(data, callback) {
        return this.call('../../app/application/update_user.php', data, callback);
    }
    getUserProfile(data, callback) {
        return this.call('../../app/application/get_user_profile.php', data, callback);
    }
    getPlans(data, callback) {
        return this.call('../../app/application/get_plans.php', data, callback);
    }
    deleteSupportUser(data, callback) {
        return this.call('../../app/application/delete_support_user.php', data, callback);
    }
    doLoginSupport(data, callback) {
        return this.call('../../app/application/do_login_support.php', data, callback);
    }
    deletePlan(data, callback) {
        return this.call('../../app/application/delete_plan.php', data, callback);
    }
    getAllGainsByDays(data, callback) {
        return this.call('../../app/application/get_all_gains_by_days.php', data, callback);
    }
    getNotices(data, callback) {
        return this.call('../../app/application/get_notices.php', data, callback);
    }
    saveNotice(data, callback) {
        return this.call('../../app/application/save_notice.php', data, callback, null, null, 'POST');
    }
    updateNotice(data, callback) {
        return this.call('../../app/application/update_notice.php', data, callback, null, null, 'POST');
    }
    getNotice(data, callback) {
        return this.call('../../app/application/get_notice.php', data, callback);
    }
    publishNotice(data, callback) {
        return this.call('../../app/application/publish_notice.php', data, callback);
    }
    deleteNotice(data, callback) {
        return this.call('../../app/application/delete_notice.php', data, callback);
    }
    unpublishNotice(data, callback) {
        return this.call('../../app/application/unpublish_notice.php', data, callback);
    }
    getCatalogNotices(data, callback) {
        return this.call('../../app/application/get_catalog_notices.php', data, callback);
    }
    getCatalogPriorities(data, callback) {
        return this.call('../../app/application/get_catalog_priorities.php', data, callback);
    }
    // callfile
    uploadImageProfile(data, progress, callback) {
        return this.callFile('../../app/application/upload_image_profile.php', data, callback, progress);
    }
}

export { UserSupport }