<?php

namespace JFStudio;

class Router {
    const Backoffice = 1;
    const Profile = 2;
    const Gains = 3;
    const Referrals = 4;
    const Signup = 5;
    const Login = 6;
    const RecoverPassword = 7;
    const NewPassword = 8;
    const Notifications = 15;
    const Plans = 16;
    const TradingView = 22;
    const Wallet = 23;
    const Calculator = 25;
    const AddFunds = 28;

    /* admin */
    const AdminUsers = 9;
    const AdminActivations = 10;
    const AdminAdministrators = 11;
    const AdminBrokers = 12;
    const AdminLogin = 13;
    const AdmiActivation = 14;
    const AdminBrokersEdit = 16;
    const AdminBrokersAdd = 17;
    const AdminBrokersCapitals = 18;
    const AdminUserEdit = 19;
    const AdminUserAdd = 20;
    const AdminAdministratorsAdd = 21;
    const AdminAdministratorsEdit = 21;
    const AdminTransactions = 24;
    const AdminDash = 26;
    const AdminAddOldComissions = 27;
    const AdminDeposits = 29;
    const AdminTransactionsList = 30;
    const AdminNotices = 31;
    const AdminNoticesEdit = 32;
    const AdminNoticesAdd = 33;
    const AdminStats = 34;

    static function getName(int $route = null)
    {
        switch ($route) 
        {
            case self::Backoffice:
                return 'Oficina virtual';
            case self::Profile:
                return 'Perfil';
            case self::Gains:
                return 'Ganancias';
            case self::Referrals:
                return 'Referidos';
            case self::Signup:
                return 'Regístrate';
            case self::Login:
                return 'Iniciar sesión';
            case self::RecoverPassword:
                return 'Recuperar contraseña';
            case self::NewPassword:
                return 'Cambiar contraseña';
            case self::Plans:
                return 'Planes';
            case self::Notifications:
                return 'Notificaciones';
            case self::TradingView:
                return 'Resultados del broker';
            case self::Wallet:
                return 'Cartera electrónica';
            case self::Calculator:
                return 'Calculadora';
            case self::AddFunds:
                return 'Añadir fondos';
            case self::AdminDash:
                return 'Administrador';
            case self::AdminUsers:
                return 'Usuarios';
            case self::AdminUserEdit:
                return 'Editar usuario';
            case self::AdminUserAdd:
                return 'Añadir usuario';
            case self::AdminActivations:
                return 'Activaciones';
            case self::AdminAdministrators:
                return 'Administradores';
            case self::AdminAdministratorsAdd:
                return 'Añadir administrador';
            case self::AdminAdministratorsEdit:
                return 'Editar administrador';
            case self::AdminBrokers:
                return 'Brokers';
            case self::AdminBrokersEdit:
                return 'Editar broker';
            case self::AdminBrokersAdd:
                return 'Añadir broker';
            case self::AdminBrokersAdd:
                return 'Capital invertido';
            case self::AdminLogin:
                return 'Iniciar sesión admin';
            case self::AdmiActivation:
                return 'Activar en plan';
            case self::AdminTransactions:
                return 'Transacciones';
            case self::AdminAddOldComissions:
                return 'Añadir comisiones atrasadas';
            case self::AdminTransactionsList:
                return 'Lista de fondeos';
            case self::AdminNotices:
                return 'Listar noticias';
            case self::AdminNoticesEdit:
                return 'Editar noticia';
            case self::AdminNoticesAdd:
                return 'Añadir noticia';
            case self::AdminDeposits:
                return 'Ver fondeos';
            case self::AdminStats:
                return 'Estadísticas';
                default: 
                return 'Sin nombre';
        }
    }
}