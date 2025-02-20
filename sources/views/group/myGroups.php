<?php ob_start(); ?>
<div class="container">
    <h1 class="title">Mes Groupes</h1>

    <?php
    // Initialiser deux tableaux pour stocker les groupes selon la propriété
    $ownerGroups = [];
    $otherGroups = [];

    if (isset($myGroups) && count($myGroups) > 0) {
        foreach ($myGroups as $group) {
            if (Session::get('user')['id'] == $group['owner_id']) {
                $ownerGroups[] = $group;
            } else {
                $otherGroups[] = $group;
            }
        }
    }
    ?>

    <?php if (!empty($ownerGroups)): ?>
        <h2 class="subtitle">Groupes dont vous êtes propriétaire</h2>
        <ul class="tableaubord grid">
            <?php foreach ($ownerGroups as $group): ?>
                <!-- Ajout de data-url et d'un onClick sur le <li> -->
                <li class="icone col-12 col-xxl-6 tableaubord--item"
                    data-url="/group/<?php echo htmlspecialchars($group['name']); ?>/manage"
                    onclick="window.location.href = this.getAttribute('data-url')">
                    <div class="flex items-center">
                        <svg width="279" height="257" viewBox="0 0 279 257" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M183.073 93.6786C194.285 93.6786 203.385 102.779 203.385 113.991V192.328C203.385 209.262 196.658 225.503 184.684 237.477C172.709 249.451 156.469 256.179 139.534 256.179C122.6 256.179 106.359 249.451 94.385 237.477C82.4107 225.503 75.6835 209.262 75.6835 192.328V113.991C75.6835 102.779 84.7719 93.6786 95.996 93.6786H183.073ZM20.5264 93.6786L71.3889 93.6554C67.2062 98.6954 64.6881 104.908 64.1808 111.438L64.0648 113.991V192.328C64.0648 205.479 67.4424 217.852 73.3505 228.623C65.3988 232.096 56.7072 233.533 48.0609 232.805C39.4146 232.076 31.086 229.205 23.8274 224.451C16.5689 219.697 10.609 213.209 6.48632 205.574C2.36359 197.939 0.207866 189.397 0.21388 180.721V113.991C0.213879 111.323 0.739663 108.68 1.76119 106.215C2.78271 103.75 4.27996 101.51 6.16738 99.6239C8.05479 97.7375 10.2954 96.2416 12.7612 95.2215C15.2269 94.2013 17.8579 93.6771 20.5264 93.6786ZM207.692 93.6554L258.473 93.6786C269.685 93.6786 278.785 102.779 278.785 113.991V180.732C278.789 189.405 276.633 197.941 272.512 205.572C268.391 213.203 262.435 219.688 255.181 224.441C247.928 229.194 239.604 232.067 230.963 232.799C222.321 233.531 213.634 232.1 205.684 228.635L206.334 227.451C211.313 218.014 214.342 207.382 214.9 196.112L214.992 192.328V113.991C214.992 106.261 212.253 99.1804 207.692 93.6554ZM139.5 0.821442C144.835 0.821442 150.117 1.87224 155.046 3.91383C159.975 5.95543 164.453 8.94785 168.226 12.7202C171.998 16.4926 174.991 20.9711 177.032 25.8999C179.074 30.8288 180.125 36.1115 180.125 41.4464C180.125 46.7814 179.074 52.0641 177.032 56.993C174.991 61.9218 171.998 66.4003 168.226 70.1727C164.453 73.945 159.975 76.9375 155.046 78.9791C150.117 81.0207 144.835 82.0714 139.5 82.0714C128.725 82.0714 118.392 77.7913 110.773 70.1727C103.155 62.554 98.8746 52.2209 98.8746 41.4464C98.8746 30.672 103.155 20.3389 110.773 12.7202C118.392 5.10157 128.725 0.821442 139.5 0.821442ZM232.392 12.4286C236.964 12.4286 241.492 13.3293 245.717 15.0792C249.942 16.8292 253.781 19.3941 257.014 22.6275C260.247 25.861 262.812 29.6997 264.562 33.9244C266.312 38.1492 267.213 42.6772 267.213 47.25C267.213 51.8228 266.312 56.3509 264.562 60.5756C262.812 64.8003 260.247 68.639 257.014 71.8725C253.781 75.106 249.942 77.6709 245.717 79.4208C241.492 81.1708 236.964 82.0714 232.392 82.0714C223.156 82.0714 214.299 78.4028 207.769 71.8725C201.239 65.3422 197.57 56.4852 197.57 47.25C197.57 38.0148 201.239 29.1578 207.769 22.6275C214.299 16.0973 223.156 12.4286 232.392 12.4286ZM46.6076 12.4286C51.1804 12.4286 55.7085 13.3293 59.9332 15.0792C64.1579 16.8292 67.9966 19.3941 71.2301 22.6275C74.4636 25.861 77.0285 29.6997 78.7784 33.9244C80.5284 38.1492 81.4291 42.6772 81.4291 47.25C81.4291 51.8228 80.5284 56.3509 78.7784 60.5756C77.0285 64.8003 74.4636 68.639 71.2301 71.8725C67.9966 75.106 64.1579 77.6709 59.9332 79.4208C55.7085 81.1708 51.1804 82.0714 46.6076 82.0714C37.3724 82.0714 28.5154 78.4028 21.9852 71.8725C15.4549 65.3422 11.7862 56.4852 11.7862 47.25C11.7862 38.0148 15.4549 29.1578 21.9852 22.6275C28.5154 16.0973 37.3724 12.4286 46.6076 12.4286Z" fill="#485051" />
                        </svg>
                    </div>
              
                    <a href="/group/<?php echo htmlspecialchars($group['name']); ?>/manage" class="text-blue-500 hover:underline flex-1">
                        <?php echo htmlspecialchars($group['name']); ?>
                    </a>
                    <form action="/group/<?php echo htmlspecialchars($group['name']); ?>/delete" method="post"
                          onsubmit="event.stopPropagation(); return confirm('Êtes-vous sûr de vouloir supprimer ce groupe ?');">
                        <button type="submit" class="button button--danger" onclick="event.stopPropagation()">
                            Supprimer
                        </button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p class="text-gray-700">Vous n'avez créé aucun groupe pour le moment.</p>
    <?php endif; ?>

    <?php if (!empty($otherGroups)): ?>
        <h2 class="subtitle">Groupes dont vous êtes membre</h2>
        <ul class="tableaubord grid">
            <?php foreach ($otherGroups as $group): ?>
                <!-- Pour les groupes dont vous êtes membre, on redirige vers /photos -->
                <li class="icone col-12 col-xxl-6"
                    data-url="/group/<?php echo htmlspecialchars($group['name']); ?>/photos"
                    onclick="window.location.href = this.getAttribute('data-url')">
                    <svg width="279" height="257" viewBox="0 0 279 257" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M183.073 93.6786C194.285 93.6786 203.385 102.779 203.385 113.991V192.328C203.385 209.262 196.658 225.503 184.684 237.477C172.709 249.451 156.469 256.179 139.534 256.179C122.6 256.179 106.359 249.451 94.385 237.477C82.4107 225.503 75.6835 209.262 75.6835 192.328V113.991C75.6835 102.779 84.7719 93.6786 95.996 93.6786H183.073ZM20.5264 93.6786L71.3889 93.6554C67.2062 98.6954 64.6881 104.908 64.1808 111.438L64.0648 113.991V192.328C64.0648 205.479 67.4424 217.852 73.3505 228.623C65.3988 232.096 56.7072 233.533 48.0609 232.805C39.4146 232.076 31.086 229.205 23.8274 224.451C16.5689 219.697 10.609 213.209 6.48632 205.574C2.36359 197.939 0.207866 189.397 0.21388 180.721V113.991C0.213879 111.323 0.739663 108.68 1.76119 106.215C2.78271 103.75 4.27996 101.51 6.16738 99.6239C8.05479 97.7375 10.2954 96.2416 12.7612 95.2215C15.2269 94.2013 17.8579 93.6771 20.5264 93.6786ZM207.692 93.6554L258.473 93.6786C269.685 93.6786 278.785 102.779 278.785 113.991V180.732C278.789 189.405 276.633 197.941 272.512 205.572C268.391 213.203 262.435 219.688 255.181 224.441C247.928 229.194 239.604 232.067 230.963 232.799C222.321 233.531 213.634 232.1 205.684 228.635L206.334 227.451C211.313 218.014 214.342 207.382 214.9 196.112L214.992 192.328V113.991C214.992 106.261 212.253 99.1804 207.692 93.6554ZM139.5 0.821442C144.835 0.821442 150.117 1.87224 155.046 3.91383C159.975 5.95543 164.453 8.94785 168.226 12.7202C171.998 16.4926 174.991 20.9711 177.032 25.8999C179.074 30.8288 180.125 36.1115 180.125 41.4464C180.125 46.7814 179.074 52.0641 177.032 56.993C174.991 61.9218 171.998 66.4003 168.226 70.1727C164.453 73.945 159.975 76.9375 155.046 78.9791C150.117 81.0207 144.835 82.0714 139.5 82.0714C128.725 82.0714 118.392 77.7913 110.773 70.1727C103.155 62.554 98.8746 52.2209 98.8746 41.4464C98.8746 30.672 103.155 20.3389 110.773 12.7202C118.392 5.10157 128.725 0.821442 139.5 0.821442ZM232.392 12.4286C236.964 12.4286 241.492 13.3293 245.717 15.0792C249.942 16.8292 253.781 19.3941 257.014 22.6275C260.247 25.861 262.812 29.6997 264.562 33.9244C266.312 38.1492 267.213 42.6772 267.213 47.25C267.213 51.8228 266.312 56.3509 264.562 60.5756C262.812 64.8003 260.247 68.639 257.014 71.8725C253.781 75.106 249.942 77.6709 245.717 79.4208C241.492 81.1708 236.964 82.0714 232.392 82.0714C223.156 82.0714 214.299 78.4028 207.769 71.8725C201.239 65.3422 197.57 56.4852 197.57 47.25C197.57 38.0148 201.239 29.1578 207.769 22.6275C214.299 16.0973 223.156 12.4286 232.392 12.4286ZM46.6076 12.4286C51.1804 12.4286 55.7085 13.3293 59.9332 15.0792C64.1579 16.8292 67.9966 19.3941 71.2301 22.6275C74.4636 25.861 77.0285 29.6997 78.7784 33.9244C80.5284 38.1492 81.4291 42.6772 81.4291 47.25C81.4291 51.8228 80.5284 56.3509 78.7784 60.5756C77.0285 64.8003 74.4636 68.639 71.2301 71.8725C67.9966 75.106 64.1579 77.6709 59.9332 79.4208C55.7085 81.1708 51.1804 82.0714 46.6076 82.0714C37.3724 82.0714 28.5154 78.4028 21.9852 71.8725C15.4549 65.3422 11.7862 56.4852 11.7862 47.25C11.7862 38.0148 15.4549 29.1578 21.9852 22.6275C28.5154 16.0973 37.3724 12.4286 46.6076 12.4286Z" fill="#485051" />
                    </svg>
                    <a href="/group/<?php echo htmlspecialchars($group['name']); ?>/photos" >
                        <?php echo htmlspecialchars($group['name']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (empty($ownerGroups) && empty($otherGroups)): ?>
        <p class="text-gray-700">Vous n'appartenez à aucun groupe pour le moment.</p>
    <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
$title = "Mes Groupes";
require __DIR__ . '/../layout.php';
?>
