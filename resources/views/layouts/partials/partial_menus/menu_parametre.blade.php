<li class="menu-item menu-item-submenu {{request()->is('parametre/*') ? 'menu-item-here menu-item-open menu-item-active' : ''}}" aria-haspopup="true" data-menu-toggle="hover">
    <a href="javascript:;" class="menu-link menu-toggle">
        <span class="svg-icon menu-icon">
            <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Layers.svg--> 
            <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:D:\xampp\htdocs\keenthemes\legacy\keen\theme\demo1\dist/../src/media/svg/icons\Home\Key.svg-->
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                     <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <polygon points="0 0 24 0 24 24 0 24"/>
        <rect fill="#000000" opacity="0.3" x="2" y="5" width="20" height="2" rx="1"/>
        <rect fill="#000000" opacity="0.3" x="2" y="17" width="20" height="2" rx="1"/>
        <rect fill="#000000" opacity="0.3" x="2" y="9" width="5" height="2" rx="1"/>
        <rect fill="#000000" opacity="0.3" x="16" y="13" width="6" height="2" rx="1"/>
        <rect fill="#000000" opacity="0.3" x="9" y="9" width="13" height="2" rx="1"/>
        <rect fill="#000000" opacity="0.3" x="2" y="13" width="12" height="2" rx="1"/>
    </g>
                </svg><!--end::Svg Icon-->
            </span>
        </span>
        <span class="menu-text">
            Parametre
        </span>
        <i class="menu-arrow"></i>
    </a>
    <div class="menu-submenu">
        <i class="menu-arrow"></i>
        <ul class="menu-subnav">
            <li class="menu-item {{Route::currentRouteName() === 'parametre.localites.index' ? 'menu-item-active' : ''}}" aria-haspopup="true">
                <a href="{{route('parametre.localites.index')}}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Localit&eacute;</span>
                </a>
            </li>
            <li class="menu-item {{Route::currentRouteName() === 'parametre.formes.index' ? 'menu-item-active' : ''}}" aria-haspopup="true">
                <a href="{{route('parametre.formes.index')}}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Forme</span>
                </a>
            </li>
             <li class="menu-item {{Route::currentRouteName() === 'parametre.modes.index' ? 'menu-item-active' : ''}}" aria-haspopup="true">
                <a href="{{route('parametre.modes.index')}}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Mode administration</span>
                </a>
            </li>
            <li class="menu-item {{Route::currentRouteName() === 'parametre.emballages.index' ? 'menu-item-active' : ''}}" aria-haspopup="true">
                <a href="{{route('parametre.emballages.index')}}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Emballage</span>
                </a>
            </li>
            <li class="menu-item {{Route::currentRouteName() === 'parametre.categories.index' ? 'menu-item-active' : ''}}" aria-haspopup="true">
                <a href="{{route('parametre.categories.index')}}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Cat&eacute;gorie</span>
                </a>
            </li>
            <li class="menu-item {{Route::currentRouteName() === 'parametre.categories.sous-categorie' ? 'menu-item-active' : ''}}" aria-haspopup="true">
                <a href="{{route('parametre.categories.sous-categorie')}}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Sous cat&eacute;gorie</span>
                </a>
            </li>
            <li class="menu-item {{Route::currentRouteName() === 'parametre.medicaments.index' ? 'menu-item-active' : ''}}" aria-haspopup="true">
                <a href="{{route('parametre.medicaments.index')}}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">M&eacute;dicament</span>
                </a>
            </li>
            <li class="menu-item {{Route::currentRouteName() === 'parametre.pharmacies.index' ? 'menu-item-active' : ''}}" aria-haspopup="true">
                <a href="{{route('parametre.pharmacies.index')}}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Pharmacie</span>
                </a>
            </li>
            <li class="menu-item {{Route::currentRouteName() === 'parametre.hopitals.index' ? 'menu-item-active' : ''}}" aria-haspopup="true">
                <a href="{{route('parametre.hopitals.index')}}" class="menu-link">
                    <i class="menu-bullet menu-bullet-dot">
                        <span></span>
                    </i>
                    <span class="menu-text">Hopital</span>
                </a>
            </li>
        </ul>
    </div>
</li>