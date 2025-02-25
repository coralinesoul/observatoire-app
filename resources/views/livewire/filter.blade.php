<div>
    <div class="md:hidden px-8 ">
    <!-- Bouton pour afficher les filtres (Visible uniquement sur mobile) -->
    <button onclick="document.getElementById('filter-panel').classList.toggle('hidden')"
        class="p-2  text-blue2 rounded">
        <i class="fa-solid fa-filter text-3xl"></i>
    </button>
        <div>Sélection :</div>
        @if(
            !empty($selectedSource) || 
            !empty($selectedTheme) || 
            !empty($selectedParametre) || 
            !empty($selectedMatrice) ||  
            !empty($selectedZone) || 
            !empty($selectedType) ||  
            !empty($selectedGpM) ||
            !empty($selectedGp) ||
            !empty($selectedFrequence) || 
            ($selectedStartyear != 1960 || $selectedStopyear != date('Y'))
        )
            <div>
                <ul class="text-gray-500 text-sm flex flex-wrap gap-1">
                    @foreach($selectedSource as $sourceId)
                        <li class="my-1">
                            <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                {{ \App\Models\Source::find($sourceId)->name }}
                                <button wire:click="removeSelection('selectedSource', {{ $sourceId }})" class="text-red-500 ml-2">&times;</button>
                            </span>
                        </li>
                    @endforeach
                    @foreach($selectedTheme as $themeId)
                        <li class="my-1">
                            <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                {{ \App\Models\Theme::find($themeId)->name }}
                                <button wire:click="removeSelection('selectedTheme', {{ $themeId }})" class="text-red-500 ml-2">&times;</button>
                            </span>
                        </li>
                    @endforeach
                    @foreach ($parametres->groupBy('groupe') as $groupe => $parametresGrouped)
                        @if(in_array($groupe, $selectedGp))
                            <li class="my-1">
                                <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                    {{ $groupe }}
                                    <button wire:click="removeSelection('selectedGp', '{{ $groupe }}')" class="text-red-500 ml-2">&times;</button>
                                </span>
                            </li>
                        @endif
                    @endforeach
                    @foreach($selectedParametre as $parametreId)
                        <li class="my-1">
                            <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                {{ \App\Models\Parametre::find($parametreId)->name }}
                                <button wire:click="removeSelection('selectedParametre', {{ $parametreId }})" class="text-red-500 ml-2">&times;</button>
                            </span>
                        </li>
                    @endforeach
                    @foreach ($matrices->groupBy('groupe') as $groupe => $matricesGrouped)
                        @if(in_array($groupe, $selectedGpM))
                            <li class="my-1">
                                <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                    {{ $groupe }}
                                    <button wire:click="removeSelection('selectedGpM', '{{ $groupe }}')" class="text-red-500 ml-2">&times;</button>
                                </span>
                            </li>
                        @endif
                    @endforeach
                    @foreach($selectedMatrice as $matriceId)
                        <li class="my-1">
                            <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                {{ \App\Models\Matrice::find($matriceId)->name }}
                                <button wire:click="removeSelection('selectedMatrice', {{ $matriceId }})" class="text-red-500 ml-2">&times;</button>
                            </span>
                        </li>
                    @endforeach
                    @foreach($selectedZone as $zoneId)
                        <li class="my-1">
                            <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                {{ \App\Models\Zone::find($zoneId)->name }}
                                <button wire:click="removeSelection('selectedZone', {{ $zoneId }})" class="text-red-500 ml-2">&times;</button>
                            </span>
                        </li>
                    @endforeach
                    @foreach($selectedType as $typeId)
                        <li class="my-1">
                            <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                {{ \App\Models\Type::find($typeId)->name }}
                                <button wire:click="removeSelection('selectedType', {{ $typeId }})" class="text-red-500 ml-2">&times;</button>
                            </span>
                        </li>
                    @endforeach
                    @foreach($selectedFrequence as $frequence)
                        <li class="my-1">
                            <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                {{ $frequence }}
                                <button wire:click="removeSelection('selectedFrequence', '{{ $frequence }}')" class="text-red-500 ml-2">&times;</button>
                            </span>
                        </li>
                    @endforeach
                    @if($selectedStartyear != 1960 || $selectedStopyear != date('Y'))
                        <li class="my-1">
                            <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                {{ $selectedStartyear }} - {{ $selectedStopyear }}
                                <button wire:click="resetYears" class="text-red-500 ml-2">&times;</button>
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
        @else
            <p class="text-gray-500 text-sm">aucune sélection appliqué</p>
        @endif
    <br>
    </div>

    <!-- Conteneur principal -->
    <div class="flex w-full">
        <!-- Panneau des filtres -->
        <div id="filter-panel" class="relative bg-blue2 bg-opacity-5 w-4/5 h-full max-w-[340px] z-50 shadow-md p-6 md:block md:h-auto md:z-auto hidden">
            <!-- Bouton de fermeture (visible uniquement en mobile) -->
            <button onclick="document.getElementById('filter-panel').classList.toggle('hidden')"
                class="md:hidden p-2 absolute top-0 right-0">
                <i class="fa fa-chevron-left text-blue1 text-2xl"></i>
            </button>

            <div class="hidden md:block">
                <div>Sélection :</div>
                @if(
                    !empty($selectedSource) || 
                    !empty($selectedTheme) || 
                    !empty($selectedParametre) || 
                    !empty($selectedMatrice) ||  
                    !empty($selectedZone) || 
                    !empty($selectedType) ||  
                    !empty($selectedGpM) ||
                    !empty($selectedGp) ||
                    !empty($selectedFrequence) || 
                    ($selectedStartyear != 1960 || $selectedStopyear != date('Y'))
                )
                    <div>
                        <ul class="text-gray-500 text-sm flex flex-wrap gap-1">
                            @foreach($selectedSource as $sourceId)
                                <li class="my-1">
                                    <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                        {{ \App\Models\Source::find($sourceId)->name }}
                                        <button wire:click="removeSelection('selectedSource', {{ $sourceId }})" class="text-red-500 ml-2">&times;</button>
                                    </span>
                                </li>
                            @endforeach
                            @foreach($selectedTheme as $themeId)
                                <li class="my-1">
                                    <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                        {{ \App\Models\Theme::find($themeId)->name }}
                                        <button wire:click="removeSelection('selectedTheme', {{ $themeId }})" class="text-red-500 ml-2">&times;</button>
                                    </span>
                                </li>
                            @endforeach
                            @foreach ($parametres->groupBy('groupe') as $groupe => $parametresGrouped)
                                @if(in_array($groupe, $selectedGp))
                                    <li class="my-1">
                                        <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                            {{ $groupe }}
                                            <button wire:click="removeSelection('selectedGp', '{{ $groupe }}')" class="text-red-500 ml-2">&times;</button>
                                        </span>
                                    </li>
                                @endif
                            @endforeach
                            @foreach($selectedParametre as $parametreId)
                                <li class="my-1">
                                    <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                        {{ \App\Models\Parametre::find($parametreId)->name }}
                                        <button wire:click="removeSelection('selectedParametre', {{ $parametreId }})" class="text-red-500 ml-2">&times;</button>
                                    </span>
                                </li>
                            @endforeach
                            @foreach ($matrices->groupBy('groupe') as $groupe => $matricesGrouped)
                                @if(in_array($groupe, $selectedGpM))
                                    <li class="my-1">
                                        <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                            {{ $groupe }}
                                            <button wire:click="removeSelection('selectedGpM', '{{ $groupe }}')" class="text-red-500 ml-2">&times;</button>
                                        </span>
                                    </li>
                                @endif
                            @endforeach
                            @foreach($selectedMatrice as $matriceId)
                                <li class="my-1">
                                    <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                        {{ \App\Models\Matrice::find($matriceId)->name }}
                                        <button wire:click="removeSelection('selectedMatrice', {{ $matriceId }})" class="text-red-500 ml-2">&times;</button>
                                    </span>
                                </li>
                            @endforeach
                            @foreach($selectedZone as $zoneId)
                                <li class="my-1">
                                    <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                        {{ \App\Models\Zone::find($zoneId)->name }}
                                        <button wire:click="removeSelection('selectedZone', {{ $zoneId }})" class="text-red-500 ml-2">&times;</button>
                                    </span>
                                </li>
                            @endforeach
                            @foreach($selectedType as $typeId)
                                <li class="my-1">
                                    <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                        {{ \App\Models\Type::find($typeId)->name }}
                                        <button wire:click="removeSelection('selectedType', {{ $typeId }})" class="text-red-500 ml-2">&times;</button>
                                    </span>
                                </li>
                            @endforeach
                            @foreach($selectedFrequence as $frequence)
                                <li class="my-1">
                                    <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                        {{ $frequence }}
                                        <button wire:click="removeSelection('selectedFrequence', '{{ $frequence }}')" class="text-red-500 ml-2">&times;</button>
                                    </span>
                                </li>
                            @endforeach
                            @if($selectedStartyear != 1960 || $selectedStopyear != date('Y'))
                                <li class="my-1">
                                    <span class="inline-flex items-center rounded-md border border-gray-500 px-1.5 py-0.5 text-sm">
                                        {{ $selectedStartyear }} - {{ $selectedStopyear }}
                                        <button wire:click="resetYears" class="text-red-500 ml-2">&times;</button>
                                    </span>
                                </li>
                            @endif
                        </ul>
                    </div>
                @else
                    <p class="text-gray-500 text-sm">aucune sélection appliqué</p>
                @endif
            </div>
                <br>
                <div>
                    <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Thèmes</h2>
                    @foreach ($themes as $theme)
                        <input type="checkbox" id="{{$theme->id}}" name="selectedTheme" value="{{$theme->id}}" wire:model="selectedTheme" wire:change="updateFilteredOptions">
                        <label>{{$theme->name}}</label>
                        <br>
                    @endforeach
                </div>
                @if(!empty($selectedTheme) && count($selectedTheme) > 0 && count($filteredGp)>0)
                        <br>
                        <div>
                            <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Types de paramètres suivis</h2>
                            @foreach ($filteredGp as $groupe)
                                <input type="checkbox" id="{{$groupe}}" name="selectedGp" value="{{$groupe}}" wire:model="selectedGp" wire:change="updateFilteredOptions">
                                <label>{{$groupe}}</label>
                                <br>
                            @endforeach
                        </div>
                    @endif
                    @if(!empty($filteredParametres) && count($filteredParametres) > 0)
                        <br>
                            <div>
                                <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Paramètres suivis</h2>
                                @foreach ($filteredParametres as $parametre)
                                    <input type="checkbox" id="{{$parametre->id}}" name="selectedParametre" value="{{$parametre->id}}" wire:model="selectedParametre" wire:change="updateFilteredOptions">
                                    <label>{{$parametre->name}}</label>
                                    <br>
                                @endforeach
                            </div>
                    @endif
                    @if(!empty($selectedTheme) && count($selectedTheme) > 0 && count($filteredGpM)>0)
                        <br>
                        <div>
                            <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Types des matrices suivies</h2>
                            @foreach ($matrices->groupBy('groupe') as $groupe => $matricesGrouped)
                                <input type="checkbox" id="{{$groupe}}" name="selectedGp" value="{{$groupe}}" wire:model="selectedGpM" wire:change="updateFilteredOptions">
                                <label>{{$groupe}}</label>
                                <br>
                            @endforeach
                        </div>
                    @endif
                    @if(!empty($filteredMatrices) && count($filteredMatrices) > 0)
                        <br>
                        <div>
                            <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Matrices suivies</h2>
                            @foreach ($filteredMatrices as $matrice)
                                <input type="checkbox" id="{{$matrice->id}}" name="selectedMatrice" value="{{$matrice->id}}" wire:model="selectedMatrice" wire:change="updateFilteredOptions">
                                <label>{{$matrice->name}}</label>
                                <br>
                            @endforeach
                        </div>
                    @endif
                    <br>
                    <div>
                        <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Sources</h2>
                        @foreach ($sources as $source)
                            <input type="checkbox" id="{{$source->id}}" name="selectedSource" value="{{$source->id}}" wire:model="selectedSource" wire:change="updateFilteredOptions">
                            <label>{{$source->name}}</label>
                            <br>
                        @endforeach
                    </div>
                    <br>
                    <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Dates</h2>       
                    <br>
                    @vite('resources/js/filters.js')
                    <div class="range_container">
                        <div class="sliders_control">
                            <input id="fromSlider" type="range" wire:model="selectedStartyear" wire:change="updateFilteredOptions" min="1960" max="{{ date('Y') }}"/>
                            <input id="toSlider" type="range" wire:model="selectedStopyear" wire:change="updateFilteredOptions"  min="1960" max="{{ date('Y') }}"/>
                        </div>
                        <div class="form_control">
                            <div class="form_control_container">
                                <input class="form_control_container__time__input" wire:model="selectedStartyear" wire:change="updateFilteredOptions" type="number" id="fromInput" min="1960" max="{{ date('Y') }}"/>
                            </div>
                            <div class="form_control_container">
                                <input class="form_control_container__time__input" wire:model="selectedStopyear" wire:change="updateFilteredOptions" type="number" id="toInput" min="0" max="{{ date('Y') }}"/>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div>
                        <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Fréquence des relevés</h2>
                        <input type="checkbox" id="optionPonctuelle" name="selectedFrequence" value="ponctuelle" wire:model="selectedFrequence" wire:change="updateFilteredOptions">
                        <label for="optionPonctuelle">Ponctuelle</label>
                        <br>
                        
                        <input type="checkbox" id="optionQuotidienne" name="selectedFrequence" value="quotidienne" wire:model="selectedFrequence" wire:change="updateFilteredOptions">
                        <label for="optionQuotidienne">Quotidienne</label>
                        <br>
                        
                        <input type="checkbox" id="optionMensuelle" name="selectedFrequence" value="mensuelle" wire:model="selectedFrequence" wire:change="updateFilteredOptions">
                        <label for="optionMensuelle">Mensuelle</label>
                        <br>
                        <input type="checkbox" id="optionPluriannuelle" name="selectedFrequence" value="pluriannuelle" wire:model="selectedFrequence" wire:change="updateFilteredOptions">
                        <label for="optionPluriannuelle">Pluriannuelle</label>
                        <br>
                        <input type="checkbox" id="optionAnnuelle" name="selectedFrequence" value="annuelle" wire:model="selectedFrequence" wire:change="updateFilteredOptions">
                        <label for="optionAnnuelle">Annuelle</label>
                    </div>
                    <br>
                    <div>
                        <label class="m-1 block text-base font-medium text-blue1" for="zone">Zones géographiques</label>
                        <div id="svg-container" class="w-64 h-auto relative"
                        x-data="{ 
                            selectedZone: @entangle('selectedZone'), 
                            hoverZone: '', 
                            cursorPos: { x: 0, y: 0 }
                        }"
                        x-on:mousemove="cursorPos = { x: $event.x, y: $event.y }">
                    
                    <!-- Le span qui s'affiche au survol de la zone -->
                    <span x-show="hoverZone"
                            x-text="hoverZone"
                            class="absolute text-white bg-black opacity-75 rounded p-2"
                            :style="{
                                transform: `translate(${cursorPos.x -40}px, ${cursorPos.y -600}px)`
                            }">
                    </span> 
                            <svg xmlns="http://www.w3.org/2000/svg"  class="w-full h-auto" viewBox="0 0 2480 3507" width="100%" height="auto">
                                <g id="zone9" data-name="Grand Large" 
                                    wire:click="updateSelectedZone(9)" wire:model="selectedZone" wire:change="updateFilteredOptions"
                                    x-data="{ selectedZone: @entangle('selectedZone') }"
                                    x-on:mouseover="hoverZone = $el.getAttribute('data-name')" 
                                    x-on:mouseout="hoverZone = ''"
                                    :class="{'cursor-pointer': true}">
                                        <path d="M911.085,1881.03 L923.029,1879.31 L927.193,1879.31 L940.377,1880.27 L946.622,1879.31 L952.867,1878.36 L961.194,1876.45 L968.827,1875.5 L972.297,1874.55 L976.46,1872.64 L981.317,1871.69 L986.175,1871.69 L994.502,1871.69 L1001.44,1871.69 L1007.69,1869.78 L1020.18,1865.01 L1033.36,1860.24 L1037.52,1859.29 L1043.08,1858.34 L1055.57,1856.43 L1062.5,1854.52 L1068.75,1851.66 L1077.08,1846.89 L1079.85,1844.98 L1084.71,1844.03 L1095.12,1841.17 L1099.98,1840.22 L1103.45,1838.31 L1115.94,1834.49 L1118.02,1833.54 L1121.49,1831.63 L1127.73,1828.77 L1131.2,1825.91 L1133.28,1824 L1139.53,1820.19 L1140.92,1819.24 L1145.77,1817.33 L1155.49,1813.51 L1158.26,1812.56 L1164.51,1810.65 L1174.22,1808.74 L1177.69,1807.79 L1187.41,1805.88 L1196.43,1803.02 L1211,1803.02 L1214.47,1802.07 L1223.49,1799.21 L1229.04,1797.3 L1235.29,1795.39 L1249.86,1792.53 L1265.82,1785.86 L1268.59,1784.9 L1272.06,1782.04 L1292.19,1780.13 L1293.58,1781.09 L1305.37,1784.9 L1309.54,1786.81 L1326.19,1782.04 L1331.05,1781.09 L1346.31,1783.95 L1350.48,1782.04 L1356.72,1779.18 L1361.58,1777.27 L1363.66,1776.32 L1368.52,1774.41 L1376.84,1771.55 L1385.17,1768.69 L1392.11,1767.73 L1403.21,1762.96 L1406.68,1762.01 L1420.56,1755.33 L1430.28,1751.52 L1434.44,1749.61 L1445.54,1746.75 L1453.17,1744.84 L1462.89,1742.93 L1469.83,1741.03 L1479.54,1737.21 L1483.71,1736.26 L1496.89,1729.58 L1503.14,1726.72 L1513.54,1723.86 L1521.18,1721 L1526.73,1719.09 L1532.28,1716.23 L1541.99,1707.64 L1548.93,1705.73 L1555.87,1702.87 L1560.04,1700.01 L1574.61,1698.1 L1578.77,1696.2 L1582.24,1693.33 L1585.71,1689.52 L1590.57,1684.75 L1598.89,1678.07 L1598.89,1662.81 L1599.59,1658.04 L1601.67,1656.13 L1608.61,1656.13 L1615.55,1658.04 L1623.18,1654.22 L1624.57,1653.27 L1628.73,1652.31 L1637.75,1650.41 L1656.49,1648.5 L1662.04,1648.5 L1672.45,1648.5 L1678.69,1649.45 L1693.96,1649.45 L1698.12,1649.45 L1713.39,1651.36 L1720.33,1653.27 L1730.04,1657.08 L1732.12,1658.04 L1737.68,1658.04 L1739.76,1657.08 L1752.94,1653.27 L1757.8,1662.81 L1760.57,1669.49 L1761.27,1673.3 L1764.74,1687.61 L1765.43,1692.38 L1766.13,1697.15 L1767.51,1704.78 L1770.29,1708.6 L1777.23,1708.6 L1782.78,1702.87 L1784.17,1700.97 L1786.25,1697.15 L1792.49,1692.38 L1795.27,1689.52 L1798.05,1686.66 L1801.52,1682.84 L1804.99,1677.12 L1809.15,1669.49 L1813.31,1665.67 L1816.78,1662.81 L1818.86,1661.85 L1825.8,1658.99 L1830.66,1656.13 L1840.37,1648.5 L1847.31,1642.78 L1852.86,1639.91 L1886.17,1633.24 L1889.64,1633.24 L1902.13,1634.19 L1908.38,1636.1 L1917.4,1638.96 L1922.95,1640.87 L1929.19,1641.82 L1936.83,1646.59 L1945.85,1651.36 L1951.4,1654.22 L1956.26,1657.08 L1961.81,1661.85 L1963.2,1662.81 L1981.24,1664.72 L1993.03,1671.39 L2003.44,1679.98 L2010.38,1686.66 L2012.46,1690.47 L2017.32,1697.15 L2022.87,1705.73 L2040.91,1707.64 L2057.57,1710.5 L2061.73,1711.46 L2079.77,1716.23 L2081.85,1717.18 L2094.34,1724.81 L2101.28,1727.67 L2108.92,1729.58 L2119.32,1731.49 L2128.35,1741.98 L2135.28,1748.66 L2138.75,1750.57 L2145,1753.43 L2156.8,1756.29 L2160.51,1758.54 L2249.92,2891.56 L2248.12,2915.83 L2247.22,2936.5 L2229.25,2951.77 L467.849,3385.83 L367.198,3402.01 L297.101,3378.64 L266.546,3313.94 L541.54,2541.08 L911.085,1881.03"
                                        :fill="selectedZone.includes(9) ? '#1d9fbf' : '#185064f3'"
                                        stroke="#FFFFFF" stroke-width="2" />
                                </g>
                                <g  id="zone11" data-name="Carteau" 
                                    wire:click="updateSelectedZone(11)" wire:model="selectedZone" wire:change="updateFilteredOptions"
                                    x-data="{ selectedZone: @entangle('selectedZone') }"
                                    x-on:mouseover="hoverZone = $el.getAttribute('data-name')" 
                                    x-on:mouseout="hoverZone = ''"
                                    :class="{'cursor-pointer': true}">
                                        <path d="M1393.69,1092.03 L1391.76,1092.63 L1390.42,1095.73 L1398.84,1098.07 L1403.77,1108.29 L1413.23,1124.47 L1420.29,1142.56 L1422.94,1154.21 L1421.82,1165.06 L1418.04,1185.43 L1412.51,1199.11 L1408.66,1206.8 L1402.03,1217.81 L1395.9,1224.34 L1393.78,1230.76 L1391.78,1233.87 L1387.65,1238.64 L1379.34,1247.48 L1365.95,1258.46 L1351.47,1271.28 L1344.89,1276.08 L1333.52,1281.79 L1323.46,1290.99 L1314.96,1291.84 L1309.89,1295.46 L1303.1,1298.04 L1302.23,1301.12 L1300.75,1307.77 L1307.64,1305 L1307.47,1299.08 L1313.89,1297.82 L1317.15,1298.53 L1313.29,1308.57 L1316.96,1315.68 L1306,1326.48 L1295.24,1340.15 L1285.36,1349.69 L1280.76,1347.33 L1278.73,1346.73 L1276.76,1347.68 L1276.19,1349.03 L1276.54,1350.96 L1281.77,1355.33 L1274.15,1363.91 L1270,1359.99 L1269.12,1359.98 L1268.4,1364.12 L1271.52,1365.93 L1271.56,1367.73 L1267.82,1370.81 L1261.21,1376.21 L1250.56,1385.76 L1247.4,1385.92 L1246.94,1376.16 L1245.34,1373.49 L1242.46,1365.05 L1239.79,1361.16 L1238.54,1357.62 L1234.7,1351.17 L1228.6,1350.86 L1227.85,1354.32 L1220.81,1354.48 L1220.17,1356.67 L1214.63,1358.4 L1213.81,1357.03 L1211.71,1350.17 L1215.14,1352.84 L1216.4,1352.41 L1212.98,1346.42 L1207.78,1345.99 L1202.86,1348.87 L1199.83,1356.62 L1200.84,1366.34 L1207.84,1383.63 L1212.65,1391.1 L1219.87,1406.87 L1219.25,1408.44 L1214.13,1417.39 L1211.2,1418.88 L1211.56,1421.98 L1208.32,1420.53 L1204.73,1422.88 L1205.71,1427.6 L1198.4,1430.08 L1194.77,1426.5 L1191.42,1422.08 L1189.9,1420.12 L1184.69,1412.36 L1179.08,1417.56 L1177.94,1423.9 L1170.74,1424.34 L1162.83,1422.37 L1154.38,1384.81 L1149.32,1381.44 L1139.1,1377.62 L1135.02,1375.3 L1131.37,1368.26 L1128.67,1361.46 L1130.61,1355.31 L1122.07,1352.03 L1116.91,1347.75 L1111.92,1336.52 L1110.64,1330.53 L1103.4,1324.5 L1098.3,1316.48 L1098.33,1313.23 L1098.17,1305.33 L1088.77,1300.45 L1083.09,1293.26 L1077.95,1292.91 L1076.29,1294.54 L1080.38,1309.65 L1081.69,1321.03 L1080.38,1322.15 L1080.38,1322.15 L1077.37,1321.44 L1076.31,1324.78 L1078.25,1329.26 L1080.71,1331.44 L1080.56,1337.34 L1077.01,1336.06 L1076.49,1334.91 L1074.52,1336.82 L1073.72,1333.39 L1068.95,1327.11 L1064.45,1323.55 L1060.59,1311.55 L1057.84,1308.31 L1056.55,1302.49 L1049.76,1293.38 L1045.85,1289.69 L1040.49,1290.73 L1041.57,1295.57 L1041.28,1300.32 L1041.62,1309.12 L1041.36,1310.2 L1040.54,1316.49 L1036.07,1317.76 L1029.11,1314.45 L1024.51,1306.78 L1021.79,1291.92 L1018.52,1283.19 L1016.48,1282.64 L1009.9,1279.8 L1004.94,1273.08 L994.916,1252.88 L995.087,1249.96 L992.651,1243.92 L988.373,1237.98 L987.994,1235.92 L984.769,1230.67 L983.948,1227.72 L979.298,1224.48 L983.448,1237.43 L981.662,1235.02 L978.987,1238.56 L977.255,1239.75 L978.218,1242.5 L977.21,1244.24 L972.459,1251.61 L971.367,1259.8 L969.139,1261.07 L969.889,1269.3 L968.637,1269.76 L962.611,1263.49 L958.19,1254.51 L954.648,1249.71 L951.999,1252.41 L952.655,1257.51 L953.249,1260.86 L954.578,1263.29 L958.441,1268.5 L965.027,1278.19 L963.697,1284.83 L962.646,1284.39 L949.979,1270.01 L948.629,1269.54 L943.953,1260.83 L941.779,1262.3 L941.493,1265.38 L937.427,1260.26 L936.658,1253.6 L934.591,1249.73 L932.571,1248.58 L931.317,1254.3 L928.301,1252.98 L921.351,1248.63 L920.014,1246.16 L926.892,1242.16 L922.287,1235.49 L915.75,1232.33 L912.152,1235.45 L904.549,1236.32 L900.234,1237.83 L892.654,1236.54 L875.331,1237.87 L867.95,1237.6 L863.135,1238.53 L848.801,1238.73 L835.054,1240.95 L825.312,1235.02 L826.173,1233.34 L827.1,1233.21 L826.589,1229.79 L851.206,1230.24 L859.765,1229.16 L862.475,1233.01 L867.2,1231.91 L873.551,1229.39 L880.376,1227.06 L881.761,1225.26 L880.846,1223.4 L880.012,1215.8 L883.377,1215.41 L884.179,1225.12 L890.444,1226.62 L898.887,1221.34 L901.058,1212.63 L902.278,1221.66 L901.669,1222.47 L906.049,1222.97 L909.766,1223.62 L918.875,1214.73 L921.094,1210.98 L926.024,1210.66 L935.662,1209.22 L940.62,1207.69 L941.181,1206.03 L945.237,1207.22 L951.149,1207.72 L955.159,1205.38 L962.964,1205.8 L966.908,1214.01 L969.719,1215.68 L976.773,1214.57 L973.622,1197.76 L966.04,1196.9 L961.1,1191.05 L956.001,1187.97 L956.863,1180.01 L960.833,1180.83 L964.225,1181.48 L963.185,1174.7 L960.611,1166.5 L971.288,1149.23 L977.029,1141.33 L985.299,1131.43 L993.039,1123.74 L997.303,1121.56 L993.809,1119.02 L996.457,1117.44 L1004.33,1116.55 L1004.5,1111.81 L1007.17,1110.44 L1000.73,1103.2 L984.39,1102.92 L983.598,1096.9 L995.067,1094.87 L999.412,1100.23 L1000.58,1099.63 L1004.05,1093.27 L999.467,1093.09 L997.413,1091.98 L992.887,1083.37 L991.566,1076.91 L988.072,1067.03 L988.662,1063.39 L987.971,1060.75 L1011.87,1037.27 L1038.26,1010.58 L1040.87,1008.55 L1046.49,1004.37 L1049.89,1000.51 L1085.4,957.769 L1116.15,922.7 L1120.99,918.663 L1137.15,910.212 L1145.11,907.53 L1156.58,901.666 L1271.98,959.163 L1331.03,893.381 L1393.69,1092.03"
                                        :fill="selectedZone.includes(11) ? '#1d9fbf' : '#185064f3'"
                                        stroke="#FFFFFF" stroke-width="2"/>
                                </g>
                                <g id="zone12" data-name="Canal de Caronte" 
                                    wire:click="updateSelectedZone(12)" wire:model="selectedZone" wire:change="updateFilteredOptions"
                                    x-data="{ selectedZone: @entangle('selectedZone') }"
                                    x-on:mouseover="hoverZone = $el.getAttribute('data-name')" 
                                    x-on:mouseout="hoverZone = ''"
                                    :class="{'cursor-pointer': true}">
                                        <path  d="M2021.93,1017.74 L2020.39,1020.36 L2015.94,1023.02 L2003.47,1034.63 L1992.89,1043.71 L1983.46,1048.46 L1982.89,1052.72 L1977.64,1057.52 L1976.47,1058.31 L1975.19,1057.86 L1963.41,1044.28 L1960.6,1046 L1956.99,1041.84 L1948.53,1031.08 L1944.65,1034.46 L1951.51,1041.61 L1953.02,1048.24 L1947.77,1053.45 L1947.11,1053.96 L1944.87,1056.53 L1947.67,1064.03 L1945.68,1065.99 L1939.21,1067.33 L1934.32,1066.55 L1928.59,1060.11 L1925.62,1053.14 L1930.93,1046.44 L1921.43,1049.64 L1911.83,1047.02 L1921.25,1062.44 L1917.32,1070.99 L1913.78,1068.1 L1911.05,1064.97 L1910.18,1059.28 L1908.57,1050.23 L1905.82,1041.54 L1908.63,1038.83 L1906.6,1031.82 L1905.67,1029.23 L1905.96,1034.32 L1902.6,1036.19 L1893.4,1035.52 L1891.24,1034.21 L1889.99,1031.57 L1890.41,1024.4 L1891.39,1022.39 L1894.52,1020.87 L1895.26,1020.56 L1894.75,1016.94 L1891.07,1013.58 L1890.46,1010.02 L1889.8,1003.08 L1891.35,997.785 L1891.99,992.851 L1892.53,981.923 L1892.67,980.723 L1893.48,978.191 L1892.49,968.935 L1901.47,965.036 L1904.8,959.284 L1906.08,965.384 L1914.65,970.508 L1917.65,970.764 L1911.99,978.639 L1911.35,982.329 L1912.56,983.176 L1914.19,981.584 L1918.96,972.09 L1918.68,968.831 L1920.51,944.183 L1921.44,942.135 L1925.75,944.813 L1927.99,960.737 L1924.56,962.963 L1925.51,980.503 L1934.56,981.54 L1935.67,958.267 L1936.93,956.064 L1961.63,955.322 L1974.05,963.347 L1971.4,965.798 L1981.3,967.106 L1995.7,966.844 L2014.22,967.65 L2027.65,969.152 L2044.66,966.777 L2067.17,971.291 L2078.57,971.94 L2086.19,971.41 L2097.27,971.238 L2154.3,973.679 L2158,975.545 L2165.37,973.818 L2169.6,973.333 L2179.42,976.405 L2187.26,976.555 L2193.18,975.161 L2193.77,975.174 L2195.57,975.214 L2208.63,976.547 L2215.11,974.419 L2225.12,975.193 L2230.31,974.52 L2249.85,974.096 L2261.48,976.013 L2269.12,976.795 L2269.28,978.321 L2271.41,978.651 L2277.56,976.627 L2286.18,977.736 L2297.87,974.807 L2304.08,972.364 L2306.24,970.589 L2313.9,968.129 L2315.47,967.752 L2320.26,971.624 L2328.29,969.202 L2333.85,969.02 L2348.58,960.293 L2354.93,956.904 L2355.93,954.794 L2360.12,953.192 L2359.22,948.923 L2357.47,942.499 L2387.78,932.287 L2392.7,933.667 L2395.48,934.448 L2401.26,938.407 L2408.08,940.341 L2408.08,940.341 L2410.82,945.173 L2404.86,947.991 L2394.89,938.662 L2393.21,938.73 L2382.11,943.847 L2362.33,957.013 L2350.9,965.648 L2352.74,970.586 L2345.73,976.541 L2320.63,987.543 L2314.46,988.698 L2311.19,983.92 L2308.14,991.585 L2295.81,996.155 L2280.38,996.563 L2268.7,998.796 L2262.17,1001.68 L2255.14,1001.84 L2245.53,1000.44 L2236.12,998.907 L2229.23,999.262 L2225,997.314 L2216.81,1000.34 L2212.35,1002.49 L2209.35,1012.47 L2209.24,1017.59 L2209.84,1023.75 L2211.25,1028.32 L2202.75,1027.05 L2202,1026.52 L2198.43,1009.8 L2199.49,1026.81 L2189.6,1022.53 L2186.74,1003.46 L2185.72,998.115 L2150.71,995.659 L2143.46,991.81 L2137.57,988.128 L2094.54,986.149 L2077.35,984.12 L2067.41,984.597 L1992.11,983.264 L1992.11,983.264 L2021.93,1017.74"
                                        :fill="selectedZone.includes(12) ? '#1d9fbf' : '#185064f3'"
                                        stroke="#FFFFFF" stroke-width="2"/>
                                </g>
                                <g id="zone10" data-name="Golfe" 
                                    wire:click="updateSelectedZone(10)" wire:model="selectedZone" wire:change="updateFilteredOptions"
                                    x-data="{ selectedZone: @entangle('selectedZone') }"
                                    x-on:mouseover="hoverZone = $el.getAttribute('data-name')" 
                                    x-on:mouseout="hoverZone = ''"
                                    :class="{'cursor-pointer': true}">
                                    <path  d="M1359.5,811.174 L1361.94,808.645 L1365.62,796.595 L1366.49,794.63 L1367.02,788.211 L1371.58,780.816 L1371.68,769.315 L1375.31,762.679 L1379.23,757.469 L1379.45,753.038 L1388.95,743.183 L1390.8,738.988 L1408.59,728.019 L1430.86,716.746 L1438.75,711.968 L1446.19,708.358 L1459,703.786 L1483.53,698.065 L1502.88,695.305 L1512.3,691.004 L1521.67,688.121 L1526.49,687.327 L1530.04,686.967 L1537.82,688.078 L1548.97,688.232 L1556.97,689.581 L1559.54,689.979 L1563.67,691.225 L1568.63,692.671 L1573.65,694.214 L1581.86,696.72 L1586.16,699.002 L1588.79,700.03 L1594.99,705.738 L1597.07,712.402 L1599.19,718.189 L1599.03,722.502 L1594.59,726.769 L1594.93,728.678 L1593.74,733.344 L1585.15,738.351 L1597.62,740.636 L1597.27,746.604 L1604.36,745.558 L1601.85,735.134 L1604.93,731.47 L1607.41,728.496 L1616.21,725.067 L1619.24,732.709 L1618.07,746.885 L1606.78,751.249 L1602.35,749.627 L1597.7,750.905 L1602.02,751.493 L1607.43,753.148 L1620.32,747.981 L1623.52,724.517 L1646.98,722.965 L1658.62,721.516 L1778.21,749.548 L1791.94,755.85 L1801.11,761.935 L1807.82,770.59 L1815.09,781.769 L1819.96,793.696 L1828.21,806.034 L1828.42,807.913 L1828.73,815.831 L1828.42,824.137 L1830.41,832.99 L1829.22,840.337 L1827.79,842.579 L1818.54,845.64 L1814.96,847.94 L1813.96,856.426 L1815.23,862.071 L1815.35,870.078 L1814.89,870.333 L1816.71,872.347 L1818.98,877.399 L1822.81,878.182 L1825.56,880.165 L1829.76,883.188 L1833.8,885.41 L1835.63,886.413 L1836.21,888.25 L1836.94,890.537 L1843.54,899.385 L1845.04,908.26 L1848.95,916.67 L1849.14,924.025 L1849.88,925.41 L1855.17,929.695 L1856.22,932.42 L1854.82,940.68 L1855.34,947.036 L1852.59,948.187 L1851.3,952.384 L1850.47,960.623 L1848.17,963.187 L1839.84,967.043 L1836.17,972.375 L1831.79,976.072 L1831.64,985.179 L1835.87,990.081 L1845.6,995.448 L1853.51,997.778 L1873,1021.04 L1877.28,1025.45 L1882.38,1028.88 L1886.98,1036.5 L1905.82,1041.54 L1908.57,1050.23 L1910.18,1059.28 L1911.05,1064.97 L1913.78,1068.1 L1917.32,1070.99 L1922.27,1076.85 L1923.58,1078.87 L1931.18,1085.12 L1933.02,1095.1 L1940.64,1097.03 L1943.58,1101.19 L1945.86,1107.14 L1947.88,1107.41 L1954,1108.87 L1962.92,1108.04 L1970.07,1112.37 L1970.36,1114.32 L1969.17,1114.88 L1966.73,1116.03 L1959.39,1119.5 L1954.55,1120.42 L1950.71,1119.6 L1949.99,1120.04 L1949.86,1120.12 L1946.28,1120.61 L1944.67,1120.84 L1944.81,1121.84 L1946.57,1133.82 L1947.84,1135.65 L1957.83,1134.47 L1965.39,1131.4 L1968.26,1133.79 L1969.2,1136.73 L1965.94,1140.85 L1966.96,1145.92 L1971.5,1148.58 L1973.06,1148.09 L1976.87,1148.74 L1990.72,1160.15 L1991.91,1165.28 L1990.64,1169.84 L1993.62,1174.41 L1993.67,1183.06 L1996.12,1184.89 L1998.57,1191.75 L2004.84,1196.73 L2017.75,1202.18 L2019.33,1202.9 L2018.97,1200.92 L2024.17,1198.24 L2033.27,1195.26 L2036.44,1198.29 L2032.57,1201.34 L2024.83,1204.28 L2022.15,1205.35 L2018.76,1206.69 L2016.98,1208.29 L2016.98,1208.29 L2016.97,1208.29 L2016.97,1208.29 L2016.97,1208.29 L2016.97,1208.29 L2016.96,1208.31 L2016.91,1208.35 L2016.55,1208.67 L2013.37,1211.51 L2014.15,1217.75 L2014.21,1229.49 L2014.96,1232.48 L2018.62,1235.94 L2024.51,1239.9 L2026.03,1242.82 L2027.25,1243.27 L2033.54,1245.57 L2034.25,1247.68 L2037.41,1247.97 L2039.35,1248.15 L2043.4,1253.09 L2044.83,1254.5 L2046.29,1253.85 L2053.1,1256.9 L2054.55,1258.37 L2057.5,1259.1 L2062.1,1266.03 L2063.38,1270.97 L2064.69,1275.17 L2065.49,1281.97 L2064.51,1282.23 L2064.34,1282.28 L2064.5,1282.57 L2066.2,1285.74 L2067.32,1288.35 L2071.09,1297.12 L2072.23,1297.24 L2073.75,1295.93 L2075.5,1294.42 L2075.85,1294.66 L2076.83,1295.33 L2079,1292.53 L2081.17,1292.29 L2089.55,1295.4 L2093.64,1295.93 L2094.19,1296 L2094.6,1294.4 L2100.26,1292.51 L2101.39,1294.67 L2103.39,1294.74 L2105.28,1302.09 L2106.43,1302.53 L2104.82,1293.77 L2104.56,1292.33 L2108.68,1292.33 L2110.44,1292.34 L2114.26,1299.88 L2115.58,1304.87 L2114.78,1305.43 L2108.77,1304.74 L2097.31,1304.53 L2091.21,1307.36 L2090.14,1310.41 L2087.45,1311.4 L2082.44,1313.24 L2082.47,1316 L2085.31,1316.33 L2088.69,1315.63 L2089.56,1316.52 L2092.33,1315.79 L2093.57,1316.34 L2097.4,1321.27 L2096.87,1323.01 L2096.32,1324.84 L2095.94,1326.09 L2088.86,1330.29 L2081.88,1333.36 L2077.47,1335.29 L2079.85,1336.11 L2089.84,1335.84 L2103.75,1340.68 L2105.59,1343.8 L2106.34,1348.45 L2100.8,1357.46 L2103.96,1360.29 L2105.47,1361.65 L2107.49,1361.8 L2113.47,1362.25 L2129.06,1358.52 L2131.4,1359.01 L2132.74,1360.05 L2132.06,1360.99 L2133.17,1364.34 L2128.42,1366.01 L2119.97,1366.2 L2116.5,1368.27 L2120,1377.59 L2126.8,1385.15 L2133.21,1386.5 L2131.02,1396.99 L2133.03,1405.82 L2126.62,1407.51 L2120.12,1408.64 L2120.13,1413.14 L2120.13,1415.39 L2129.25,1430.79 L2130.73,1431.17 L2130.4,1430.5 L2123.88,1417.02 L2126.65,1411.41 L2136.71,1408.8 L2148.85,1413.9 L2153.89,1416.81 L2160.47,1418.29 L2165,1419.18 L2168.11,1416.9 L2171.78,1414.21 L2172.83,1411.19 L2171.43,1408.9 L2172.23,1408.2 L2171.28,1406.98 L2172.36,1405.42 L2172.53,1406.81 L2173.84,1406.63 L2177.42,1414.41 L2174.95,1423.63 L2169.48,1426.99 L2169.39,1427.79 L2180.76,1424.89 L2186.28,1424.53 L2187.92,1425.93 L2190.26,1426.15 L2191.76,1429.2 L2192.29,1432.71 L2189.33,1435.56 L2186.62,1442.53 L2191.33,1447.96 L2190.9,1449.86 L2191.92,1452.28 L2191.39,1453.58 L2190.43,1455.95 L2189.98,1457.04 L2187.78,1457.87 L2184.1,1459.25 L2182.58,1459.83 L2182.16,1459 L2178.25,1451.21 L2177.11,1447.64 L2177.88,1446.61 L2173.81,1448.37 L2171.55,1452.73 L2170.97,1457.17 L2165.04,1467.25 L2163.72,1472.36 L2164.61,1473.11 L2164.18,1477.56 L2162.67,1479.6 L2161.03,1483.44 L2161.99,1484.77 L2166.45,1490.96 L2169.19,1498.37 L2171.19,1499.38 L2178.16,1500.98 L2184.59,1504.51 L2186.2,1503.68 L2188.01,1503.9 L2184.04,1510.9 L2185.65,1518.26 L2182.95,1520.48 L2181.36,1521.79 L2178.36,1524.71 L2176.28,1523.54 L2170.84,1520.55 L2167.1,1515.03 L2165.73,1514.61 L2156.26,1511.68 L2153.05,1509.93 L2145.66,1504.22 L2142.28,1508.63 L2141.59,1509.52 L2140.12,1509.03 L2137.46,1515.43 L2140.8,1522.09 L2145.18,1525.87 L2148.69,1534.72 L2146.79,1536.19 L2142.06,1538.35 L2143.44,1544.99 L2142.77,1550.87 L2142.56,1552.76 L2143.33,1552.25 L2145.95,1550.49 L2147.69,1549.36 L2151.65,1552.68 L2144.43,1554.94 L2160.51,1758.54 L2156.8,1756.29 L2145,1753.43 L2138.75,1750.57 L2135.28,1748.66 L2128.35,1741.98 L2119.32,1731.49 L2108.92,1729.58 L2101.28,1727.67 L2094.34,1724.81 L2081.85,1717.18 L2079.77,1716.23 L2061.73,1711.46 L2057.57,1710.5 L2040.91,1707.64 L2022.87,1705.73 L2017.32,1697.15 L2012.46,1690.47 L2010.38,1686.66 L2003.44,1679.98 L1993.03,1671.39 L1981.24,1664.72 L1963.2,1662.81 L1959.96,1660.26 L1956.26,1657.08 L1951.4,1654.22 L1945.85,1651.36 L1936.83,1646.59 L1929.19,1641.82 L1922.95,1640.87 L1917.4,1638.96 L1908.38,1636.1 L1902.13,1634.19 L1889.64,1633.24 L1886.17,1633.24 L1852.86,1639.91 L1848.7,1641.82 L1847.87,1642.49 L1847.31,1642.78 L1840.37,1648.5 L1830.66,1656.13 L1825.8,1658.99 L1820.25,1660.9 L1818.86,1661.85 L1816.78,1662.81 L1813.31,1665.67 L1809.15,1669.49 L1808.55,1670.58 L1807.76,1671.39 L1806.37,1674.26 L1804.29,1678.26 L1801.52,1682.84 L1798.05,1686.66 L1792.49,1692.38 L1786.25,1697.15 L1784.17,1700.97 L1782.78,1702.87 L1777.23,1708.6 L1770.29,1708.6 L1767.51,1704.78 L1766.13,1697.15 L1764.74,1687.61 L1761.27,1673.3 L1760.57,1669.49 L1757.8,1662.81 L1752.94,1653.27 L1739.76,1657.08 L1737.68,1658.04 L1732.12,1658.04 L1730.04,1657.08 L1720.33,1653.27 L1713.39,1651.36 L1698.12,1649.45 L1678.69,1649.45 L1672.45,1648.5 L1662.04,1648.5 L1656.49,1648.5 L1637.75,1650.41 L1628.73,1652.31 L1624.57,1653.27 L1621.65,1654.99 L1615.55,1658.04 L1608.61,1656.13 L1601.67,1656.13 L1599.59,1658.04 L1598.89,1662.81 L1598.89,1678.07 L1590.57,1684.75 L1585.71,1689.52 L1582.24,1693.33 L1578.77,1696.2 L1574.61,1698.1 L1566.97,1699.06 L1560.04,1700.01 L1555.87,1702.87 L1548.93,1705.73 L1541.99,1707.64 L1532.28,1716.23 L1526.73,1719.09 L1521.18,1721 L1513.54,1723.86 L1503.14,1726.72 L1496.89,1729.58 L1483.71,1736.26 L1479.54,1737.21 L1469.83,1741.03 L1462.89,1742.93 L1453.17,1744.84 L1445.54,1746.75 L1437.91,1748.66 L1434.44,1749.61 L1430.28,1751.52 L1424.03,1753.43 L1421.95,1754.38 L1410.15,1760.1 L1406.68,1762.01 L1403.21,1762.96 L1392.11,1767.73 L1385.17,1768.69 L1376.84,1771.55 L1368.52,1774.41 L1363.66,1776.32 L1361.58,1777.27 L1356.72,1779.18 L1350.48,1782.04 L1346.65,1783.8 L1341.62,1783.07 L1331.05,1781.09 L1326.19,1782.04 L1309.54,1786.81 L1305.37,1784.9 L1293.58,1781.09 L1292.19,1780.13 L1272.06,1782.04 L1268.59,1784.9 L1265.82,1785.86 L1249.86,1792.53 L1235.29,1795.39 L1229.04,1797.3 L1223.49,1799.21 L1214.47,1802.07 L1211,1803.02 L1210.26,1803.02 L1196.43,1803.02 L1187.41,1805.88 L1177.69,1807.79 L1174.22,1808.74 L1164.51,1810.65 L1158.26,1812.56 L1155.49,1813.51 L1145.77,1817.33 L1140.92,1819.24 L1139.53,1820.19 L1133.28,1824 L1127.73,1828.77 L1121.49,1831.63 L1118.02,1833.54 L1115.94,1834.49 L1103.45,1838.31 L1099.98,1840.22 L1095.12,1841.17 L1084.71,1844.03 L1079.85,1844.98 L1077.08,1846.89 L1068.75,1851.66 L1062.5,1854.52 L1055.57,1856.43 L1043.08,1858.34 L1037.52,1859.29 L1033.36,1860.24 L1020.18,1865.01 L1007.69,1869.78 L1001.44,1871.69 L994.502,1871.69 L986.175,1871.69 L981.317,1871.69 L976.46,1872.64 L972.297,1874.55 L968.827,1875.5 L961.194,1876.45 L952.867,1878.36 L946.622,1879.31 L940.377,1880.27 L927.193,1879.31 L923.029,1879.31 L916.856,1880.2 L916.09,1880.27 L911.085,1881.03 L927.97,1850.9 L961.279,1661.2 L951.113,1626.85 L983.07,1619.3 L994.473,1617.88 L1003.38,1617.74 L1024.19,1619.57 L1033.65,1621.58 L1045.15,1627.13 L1049.05,1630.64 L1054.97,1638.72 L1057.08,1638.32 L1062.24,1622.95 L1066.01,1608.54 L1070.66,1593.74 L1073.31,1587.4 L1079.44,1576.93 L1087.49,1567.7 L1096.78,1554.4 L1102.86,1549.7 L1112.63,1537.43 L1135.84,1513.97 L1148.28,1501.94 L1158.81,1492.56 L1192.41,1455.39 L1212.98,1433.23 L1215.06,1429.42 L1227.99,1416.57 L1253.21,1391.92 L1257.81,1385.95 L1269.68,1373.14 L1279.31,1364.54 L1287.05,1355.99 L1302.76,1342.34 L1305.36,1340.74 L1317.78,1328.35 L1333.78,1313.59 L1347.96,1296.35 L1356.47,1288.61 L1365.44,1279 L1376.78,1269.04 L1381.3,1264.21 L1381.26,1262.95 L1389.61,1255.76 L1402.63,1243.05 L1409.64,1237.1 L1414.08,1233.17 L1429.37,1216.36 L1434.34,1209.58 L1438.95,1200.48 L1440.32,1190.83 L1440.7,1181.41 L1442.66,1173.52 L1443.02,1166.61 L1441.37,1154.49 L1440.7,1131.83 L1439.52,1125.22 L1434.65,1115.72 L1422.35,1099.94 L1414.26,1093.42 L1406.72,1090.99 L1393.69,1092.03 L1331.03,893.381 L1331.14,893.252 L1330.84,892.532 L1312.56,848.571 L1314.4,841.506 L1323.83,835.14 L1333.33,828.543 L1355.96,814.243 L1359.5,811.174"             
                                    :fill="selectedZone.includes(10) ? '#1d9fbf' : '#185064f3'"
                                    stroke="#FFFFFF" stroke-width="2" />
                                </g>
                                <g id="zone2" data-name="Etangs - Littoraux" 
                                    wire:click="updateSelectedZone(2)" wire:model="selectedZone" wire:change="updateFilteredOptions"
                                    x-data="{ selectedZone: @entangle('selectedZone') }"
                                    x-on:mouseover="hoverZone = $el.getAttribute('data-name')" 
                                    x-on:mouseout="hoverZone = ''"
                                    :class="{'cursor-pointer': true}">
                                    <path
                                        d="M520.8,1053.26 L513.841,1046.29 L510.185,1039.06 L504.91,1031.48 L501.175,1025.82 L499.977,1022.34 L496.633,1017.21 L492.795,1012.69 L480.75,1002.61 L467.552,993.541 L436.527,976.65 L413.226,961.987 L396.965,953.818 L384.104,946 L352.468,925.531 L335.64,913.482 L328.06,906.926 L325.219,905.642 L315.692,888.788 L288.596,849.055 L281.618,838.421 L267.662,819.112 L266.264,815.281 L263.567,812.539 L280.244,785.952 L363.821,723.045 L412.349,685.301 L538.163,568.473 L728.233,413.901 L766.876,376.157 L788.893,366.384 L800.463,364.137 L817.988,357.173 L839.106,360.767 L855.167,369.086 L859.947,375.581 L874.27,387.531 L891.251,405.401 L914.595,343.019 L918.864,336.644 L925.154,330.69 L929.76,326.646 L934.216,322.68 L941.353,315.912 L951.118,308.612 L963.964,301.591 L1043.95,266.542 L1076.58,251.884 L1092.94,243.417 L1133.52,218.552 L1177.11,199.231 L1194.18,197.434 L1203.17,197.883 L1221.14,200.579 L1239.11,210.464 L1261.58,236.526 L1281.35,265.283 L1301.12,286.852 L1319.99,291.345 L1334.37,291.345 L1664.3,233.942 L1685.64,232.594 L1752.82,220.687 L1828.31,214.845 L1867.17,222.035 L1924.69,251.242 L1944.46,268.541 L1963.33,305.162 L1970.06,330.957 L1970.73,361.062 L1971.63,400.604 L1971.46,446.717 L1979.33,470.307 L1987.41,480.193 L2053.69,545.796 L2064.81,560.006 L2070.6,568.572 L2069.75,574.862 L2074.98,586.264 L2075.88,596.855 L2079.02,612.582 L2089.36,622.917 L2093.75,636.326 L2097.12,643.378 L2100.21,644.128 L2103.32,644.913 L2108.14,645.397 L2117.16,637.794 L2122.97,631.716 L2127.59,629.675 L2133.66,628.825 L2139.34,626.278 L2145.67,634.973 L2146.18,641.058 L2149.86,656.108 L2154.64,666.903 L2155.12,675.618 L2157.01,682.538 L2162.19,689.172 L2167.8,700.513 L2170.5,703.739 L2171.94,707.482 L2176.34,719.668 L2181.62,720.243 L2192.16,722.913 L2197.23,725.555 L2202.58,729.381 L2168.78,797.849 L2145.41,844.58 L2136.43,886.818 L2142.72,945.231 L2191.24,962.306 L2237.08,959.61 L2291.9,953.319 L2336.83,941.637 L2374.8,930.066 L2396.76,931.021 L2409.79,933.492 L2414.9,935.346 L2415.87,937.887 L2415.64,940.7 L2413.74,941.424 L2408.08,940.341 L2401.26,938.407 L2395.48,934.448 L2392.7,933.667 L2392.45,932.701 L2387.78,932.287 L2357.47,942.499 L2359.22,948.923 L2359.86,951.963 L2359.66,952.278 L2360.12,953.192 L2355.93,954.794 L2355.31,956.094 L2351.66,958.301 L2333.85,969.02 L2328.29,969.202 L2320.26,971.624 L2315.47,967.752 L2313.9,968.129 L2306.24,970.589 L2304.08,972.364 L2297.87,974.807 L2286.18,977.736 L2277.56,976.627 L2271.41,978.651 L2269.28,978.321 L2269.12,976.795 L2261.48,976.013 L2249.85,974.096 L2230.31,974.52 L2225.12,975.193 L2215.11,974.419 L2208.63,976.547 L2195.57,975.214 L2194.01,975.122 L2193.77,975.174 L2193.18,975.161 L2187.26,976.555 L2179.42,976.405 L2169.6,973.333 L2165.37,973.818 L2158,975.545 L2154.3,973.679 L2097.27,971.238 L2086.19,971.41 L2078.57,971.94 L2067.17,971.291 L2044.66,966.777 L2027.65,969.152 L2014.22,967.65 L1995.7,966.844 L1981.3,967.106 L1971.4,965.798 L1974.05,963.347 L1961.63,955.322 L1936.93,956.064 L1935.67,958.267 L1934.56,981.54 L1925.51,980.503 L1924.56,962.963 L1927.99,960.737 L1925.75,944.813 L1921.44,942.135 L1920.51,944.183 L1918.68,968.831 L1918.96,972.09 L1914.19,981.584 L1912.56,983.176 L1911.35,982.329 L1911.99,978.639 L1917.65,970.764 L1914.65,970.508 L1906.08,965.384 L1904.8,959.284 L1901.47,965.036 L1892.49,968.935 L1893.48,978.191 L1892.67,980.723 L1892.53,981.923 L1891.99,992.851 L1891.35,997.785 L1889.8,1003.08 L1890.46,1010.02 L1891.07,1013.58 L1894.75,1016.95 L1895.26,1020.56 L1894.52,1020.87 L1891.39,1022.39 L1890.41,1024.4 L1889.99,1031.57 L1891.24,1034.21 L1893.4,1035.52 L1902.6,1036.19 L1905.96,1034.32 L1905.67,1029.23 L1906.6,1031.82 L1908.63,1038.83 L1905.82,1041.54 L1886.98,1036.5 L1882.38,1028.88 L1877.28,1025.45 L1873,1021.04 L1853.51,997.778 L1845.6,995.448 L1835.87,990.081 L1831.64,985.179 L1831.79,976.072 L1836.17,972.375 L1839.84,967.043 L1848.17,963.187 L1850.47,960.623 L1851.3,952.384 L1852.59,948.187 L1855.34,947.036 L1854.82,940.68 L1856.22,932.42 L1855.17,929.695 L1849.88,925.41 L1848.95,916.67 L1845.04,908.26 L1843.54,899.385 L1840.07,892.645 L1838.15,890.542 L1836.21,888.25 L1835.63,886.413 L1833.8,885.41 L1833.42,884.956 L1829.76,883.188 L1825.56,880.165 L1822.86,877.341 L1822.81,878.182 L1820.17,877.059 L1818.98,877.399 L1816.71,872.347 L1814.89,870.333 L1815.35,870.078 L1815.23,862.071 L1813.96,856.426 L1814.96,847.94 L1818.54,845.64 L1827.79,842.579 L1829.22,840.337 L1830.41,832.99 L1828.42,824.137 L1829.11,817.259 L1829.01,812.691 L1828.42,807.913 L1828.21,806.034 L1819.96,793.696 L1815.09,781.769 L1807.82,770.59 L1801.11,761.935 L1791.94,755.85 L1778.21,749.548 L1658.62,721.516 L1646.98,722.965 L1623.52,724.517 L1620.32,747.981 L1607.43,753.148 L1602.02,751.493 L1597.7,750.905 L1602.35,749.627 L1606.78,751.249 L1618.07,746.885 L1619.24,732.709 L1616.21,725.067 L1607.41,728.496 L1604.93,731.47 L1601.85,735.134 L1604.36,745.558 L1597.27,746.604 L1597.62,740.636 L1585.15,738.351 L1593.74,733.344 L1594.93,728.678 L1594.59,726.769 L1599.03,722.502 L1599.19,718.189 L1597.07,712.402 L1594.99,705.738 L1588.79,700.03 L1586.16,699.002 L1581.86,696.72 L1573.65,694.214 L1568.63,692.671 L1563.67,691.225 L1559.54,689.979 L1556.97,689.581 L1548.97,688.232 L1537.82,688.078 L1530.04,686.967 L1526.49,687.327 L1521.67,688.121 L1512.3,691.004 L1502.88,695.305 L1483.53,698.065 L1459,703.786 L1446.19,708.358 L1438.75,711.968 L1430.86,716.746 L1408.59,728.019 L1390.8,738.988 L1388.95,743.183 L1379.45,753.038 L1378.37,755.574 L1379.23,757.469 L1375.31,762.679 L1371.68,769.315 L1369.89,776.468 L1371.53,778.863 L1367.02,788.211 L1366.49,794.63 L1365.62,796.595 L1361.94,808.645 L1359.5,811.174 L1355.96,814.243 L1333.33,828.543 L1323.83,835.14 L1314.4,841.506 L1312.56,848.571 L1330.84,892.532 L1328.35,893.636 L1317.97,870.494 L1313.19,871.934 L1314.31,874.248 L1312.77,875.337 L1307.63,862.92 L1309.79,864.855 L1314.32,861.809 L1314.1,861.348 L1305.07,842.037 L1303.82,842.084 L1302.83,840.231 L1296.44,842.36 L1286.78,842.722 L1271.53,851.356 L1256.95,862.705 L1251.02,868.357 L1242.6,877.559 L1242.55,877.621 L1235.2,887.378 L1235.49,887.877 L1235.17,888.34 L1272.94,958.104 L1271.98,959.163 L1261.19,940.755 L1257.07,942.478 L1257.77,943.714 L1256.4,944.894 L1251.27,932.514 L1254.89,929.721 L1249.78,920.539 L1247.96,917.779 L1244.29,911.528 L1243.01,910.466 L1239.53,912.806 L1235.63,907.89 L1233.21,902.004 L1237.71,899.937 L1232.03,890.468 L1232.04,890.208 L1231.86,890.183 L1230.5,887.928 L1228.24,884.209 L1226.52,881.576 L1225.3,878.553 L1224.32,878.014 L1216.55,873.514 L1215.98,871.984 L1218.69,869.949 L1229.14,865.209 L1231.62,860.248 L1225.05,857.555 L1229.6,851.172 L1229.61,851.174 L1229.3,851.682 L1230.64,851.733 L1234.87,854.016 L1235.91,851.935 L1235.92,851.936 L1237.25,849.285 L1242.29,838.892 L1237.67,835.128 L1238.69,832.037 L1240.59,829.249 L1246.01,831.159 L1248.34,824.538 L1250.53,823.203 L1249.87,820.187 L1244.67,811.482 L1245.96,806.26 L1254.82,796.869 L1256.69,792.504 L1263.17,785.73 L1268.66,778.588 L1271.52,776.223 L1272.13,776.118 L1283.24,767.822 L1288.65,764.376 L1289.58,762.809 L1290.54,762.057 L1290.97,760.494 L1295.37,757.995 L1297.93,754.179 L1299.73,755.641 L1303.96,753.989 L1325.97,743.067 L1329.12,742.215 L1337.13,737.765 L1338.18,736.045 L1340.43,736.117 L1360.74,724.321 L1360.09,721.631 L1359.95,721.327 L1358.51,715.883 L1355.46,711.905 L1348.92,711.36 L1343.41,718.286 L1337.29,714.449 L1335.94,713.995 L1335.27,714.138 L1334.39,714.001 L1329.45,715.378 L1321.7,722.886 L1314.5,726.04 L1309.93,728.114 L1302.21,731.401 L1286.68,732.334 L1280.96,731.156 L1274.9,725.472 L1273.22,726.859 L1269.77,728.393 L1269.26,731.195 L1267.94,732.639 L1268.77,733.855 L1235.46,748.583 L1234.93,745.607 L1235.18,745.507 L1234.76,744.628 L1229.66,746.578 L1228.87,749.706 L1230.3,753.678 L1230.3,753.721 L1230.31,753.715 L1230.5,754.251 L1230.83,756.574 L1229.17,759.876 L1227.43,762.861 L1226.72,767.117 L1221.94,777.19 L1219.66,780.455 L1216.64,788.92 L1211.57,796.339 L1208.27,800.524 L1207.66,807.86 L1204.15,816.056 L1203.29,816.217 L1202.21,816.272 L1202.21,816.272 L1202.21,816.272 L1202.21,816.272 L1202.21,816.272 L1202.21,816.272 L1202.21,816.272 L1202.21,816.273 L1202.14,816.276 L1201.22,816.324 L1197.86,816.498 L1193.43,812.154 L1188.13,805.932 L1186.52,797.485 L1180.92,789.269 L1185.69,786.546 L1179.95,783.279 L1178,780.688 L1174.71,778.451 L1172.15,772.364 L1167.12,762.218 L1163.68,754.836 L1163.46,754.821 L1163.37,754.638 L1161.5,753.425 L1159.08,754.533 L1132.99,707.784 L1136.31,705.808 L1136.96,698.686 L1136.11,697.926 L1132.79,697.948 L1128.82,691.441 L1129.62,690.282 L1126.54,689.925 L1118.46,690.274 L1109.07,694.196 L1094.92,690.429 L1091.5,688.533 L1091.94,681.148 L1091.81,680.621 L1090.64,678.952 L1090.41,676.408 L1086.36,671.359 L1090.5,675.568 L1112.46,634.389 L1103.82,614.696 L1103.79,612.666 L1101.25,610.172 L1097.37,601.427 L1079.65,562.716 L1062.45,557.612 L1058.3,555.209 L1058.09,552.021 L1058.03,545.79 L1057.48,544.517 L1054.76,541.965 L1047.44,529.879 L1045.72,523.129 L1042.95,517.004 L1043.36,515.658 L1044.17,513.002 L1048.57,509.623 L1050.65,510.919 L1052.53,510.92 L1055.93,508.506 L1046.21,486.926 L1037.41,488.223 L1035.19,488.009 L1021.66,495.292 L1010.3,500.538 L1007.09,502.045 L996.914,506.545 L992.648,508.621 L975.981,515.015 L972.683,516.4 L974.159,525.166 L976.013,526.525 L981.079,536.399 L988.373,556.551 L989.517,557.842 L995.528,565.432 L1008.53,577.798 L1012.97,582.314 L1022.44,593.194 L1026.72,596.942 L1028.46,599.555 L1033.96,613.523 L1049.93,649.263 L1051.78,656.076 L1051.45,656.686 L1052.11,657.286 L1053.18,661.191 L1057.37,667.688 L1059.29,671.749 L1064.19,681.66 L1072.93,703.072 L1096.29,753.563 L1097.85,757.146 L1098.85,762.292 L1098.88,762.424 L1102.91,771.883 L1105.5,777.868 L1108.05,781.256 L1111.67,793.319 L1114.93,800.206 L1117.18,800.01 L1147.36,869.366 L1151.67,882.234 L1151.87,885.591 L1157.03,897.8 L1156.58,901.666 L1145.11,907.53 L1137.15,910.212 L1120.99,918.663 L1116.15,922.7 L1085.4,957.769 L1082.26,955.013 L1084.55,947.624 L1080.19,946.36 L1071.08,943.153 L1066.19,938.903 L1054.41,928.679 L1048.97,923.754 L990.881,873.636 L988.552,860.781 L985.917,854.787 L981.024,847.141 L978.976,844.617 L975.211,841.244 L973.044,839.303 L970.157,837.627 L966.612,835.568 L964.11,834.115 L959.719,832.499 L954.582,831.757 L949.333,830.458 L944.146,830.25 L922.728,813.057 L889.178,783.63 L874.638,771.864 L869.646,765.428 L844.586,743.229 L843.081,743.46 L835.65,738.383 L834.206,735.644 L833.647,727.91 L830.782,717.31 L820.982,717.968 L822.224,732.098 L817.729,737.901 L807.957,745.911 L800.487,753.682 L795.862,761.153 L794.523,763.112 L793.345,762.072 L790.787,768.574 L790.771,768.597 L787.665,768.793 L790.161,770.123 L791.738,770.867 L792.85,772.782 L796.314,773.025 L801.901,777.676 L803.103,778.931 L805.997,784.109 L806.95,783.925 L807.351,784.458 L808.897,783.549 L813.009,787.192 L817.154,791.018 L819.158,793.069 L819.854,793.781 L823.465,797.478 L824.759,802.668 L826.764,804.873 L840.729,817.062 L841.361,816.389 L841.245,816.332 L844.076,812.334 L941.006,897.77 L940.891,898.661 L942.081,899.067 L1017.67,965.758 L1018.85,968.751 L1032.07,980.692 L1040.92,988.407 L1049.89,1000.51 L1046.56,1004.28 L1040.87,1008.55 L1044.21,1002.31 L1043.8,993.857 L1036.23,988.371 L1033,990.589 L1026.75,995.769 L1023.35,997.41 L1023.76,1002.03 L1017.41,998.196 L1010.05,1006.04 L1012,1008.95 L1013.07,1012.57 L1008.67,1012.56 L1007.12,1010.65 L1004.82,1011.75 L1002.96,1014.67 L994.921,1017.68 L974.834,1021.94 L970.373,1018.25 L972.522,1014.24 L939.07,984.537 L929.128,975.708 L927.387,975.263 L915.334,967.091 L913.943,966.509 L913.357,966.667 L907.06,969.364 L903.158,973.252 L899.524,977.826 L881.993,962.324 L880.503,965.985 L878.824,966.728 L871.868,973.106 L863.158,970.144 L860.503,967.22 L860.694,968.565 L857.346,975.191 L859.65,976.302 L858.897,978.048 L859.145,981.243 L859.766,983.859 L857.764,987.113 L851.883,978.854 L849.381,981.15 L845.344,988.688 L842.279,987.921 L845.805,979.855 L842.576,978.757 L838.309,990.716 L836.449,992.658 L818.482,977.819 L808.333,993.036 L803.951,994.034 L801.481,999.03 L806.175,1002.71 L803.849,1001.46 L800.023,999.151 L795.642,1002.68 L789.057,1009.73 L793.26,1012.78 L798.087,1015.87 L798.133,1017.63 L798.374,1018.66 L801.377,1025.85 L798.79,1033.71 L804.51,1038.9 L815.053,1033.26 L811.738,1039.25 L810.471,1042.57 L810.835,1044.64 L813.95,1051.03 L829.112,1063.75 L851.823,1059.22 L876.569,1056.64 L895.237,1055.51 L909.531,1055.04 L911.739,1054.36 L912.554,1052.8 L911.655,1050.94 L912.044,1046.36 L913.514,1043.53 L922.771,1049.8 L924.704,1051.4 L928.93,1054.89 L929.534,1055.38 L934.304,1062.36 L940.972,1067.24 L958.995,1082.37 L960.94,1080.1 L966.645,1080.75 L985.59,1059.65 L988.295,1058.96 L993.967,1054.86 L987.971,1060.75 L988.662,1063.39 L988.072,1067.03 L991.566,1076.91 L992.887,1083.37 L997.413,1091.98 L999.467,1093.09 L1004.05,1093.27 L1000.58,1099.63 L999.412,1100.23 L995.067,1094.87 L983.598,1096.9 L984.39,1102.92 L1000.73,1103.2 L1004.74,1107.71 L1004.76,1107.74 L1007.17,1110.44 L1004.5,1111.81 L1004.33,1116.55 L996.457,1117.44 L993.809,1119.02 L997.303,1121.56 L993.039,1123.74 L985.299,1131.43 L977.029,1141.33 L971.288,1149.23 L960.611,1166.5 L963.185,1174.7 L964.225,1181.48 L960.833,1180.83 L956.863,1180.01 L956.001,1187.97 L961.1,1191.05 L966.04,1196.9 L973.622,1197.76 L976.773,1214.57 L969.719,1215.68 L966.908,1214.01 L962.964,1205.8 L955.159,1205.38 L951.149,1207.72 L945.237,1207.22 L941.181,1206.03 L940.62,1207.69 L935.662,1209.22 L926.024,1210.66 L921.094,1210.98 L918.875,1214.73 L909.766,1223.62 L906.049,1222.97 L901.669,1222.47 L902.278,1221.66 L901.058,1212.63 L898.887,1221.34 L890.444,1226.62 L884.179,1225.12 L883.377,1215.41 L880.012,1215.8 L880.846,1223.4 L881.761,1225.26 L880.376,1227.06 L873.551,1229.39 L867.2,1231.91 L862.475,1233.01 L859.765,1229.16 L851.206,1230.24 L826.589,1229.79 L827.1,1233.21 L826.173,1233.34 L825.312,1235.02 L835.054,1240.95 L848.801,1238.73 L863.135,1238.53 L867.95,1237.6 L875.331,1237.87 L892.654,1236.54 L900.234,1237.83 L904.549,1236.32 L912.152,1235.45 L915.75,1232.33 L922.287,1235.49 L926.892,1242.16 L920.014,1246.16 L921.103,1248.5 L921.318,1248.57 L921.351,1248.63 L928.301,1252.98 L931.317,1254.3 L932.571,1248.58 L934.591,1249.73 L936.658,1253.6 L937.427,1260.26 L941.493,1265.38 L941.779,1262.3 L943.953,1260.83 L948.629,1269.54 L949.979,1270.01 L962.646,1284.39 L963.697,1284.83 L965.027,1278.19 L958.441,1268.5 L954.578,1263.29 L953.249,1260.86 L952.655,1257.51 L951.999,1252.41 L954.648,1249.71 L958.19,1254.51 L962.611,1263.49 L968.637,1269.76 L969.889,1269.3 L969.139,1261.07 L971.367,1259.8 L972.459,1251.61 L977.21,1244.24 L978.218,1242.5 L977.255,1239.75 L978.987,1238.56 L981.662,1235.02 L983.448,1237.43 L979.298,1224.48 L983.948,1227.72 L984.769,1230.67 L987.994,1235.92 L988.373,1237.98 L992.651,1243.92 L995.087,1249.96 L994.916,1252.88 L1004.94,1273.08 L1009.9,1279.8 L1016.48,1282.64 L1018.52,1283.19 L1021.79,1291.92 L1024.51,1306.78 L1029.11,1314.45 L1036.07,1317.76 L1040.54,1316.49 L1041.36,1310.2 L1041.62,1309.12 L1041.28,1300.32 L1041.57,1295.57 L1040.49,1290.73 L1045.85,1289.69 L1049.76,1293.38 L1056.55,1302.49 L1057.84,1308.31 L1060.59,1311.55 L1064.45,1323.55 L1068.95,1327.11 L1073.72,1333.39 L1074.52,1336.82 L1076.49,1334.91 L1077.01,1336.06 L1080.56,1337.34 L1080.71,1331.44 L1078.25,1329.26 L1076.31,1324.78 L1077.37,1321.44 L1080.38,1322.15 L1081.69,1321.03 L1080.38,1309.65 L1076.29,1294.54 L1077.95,1292.91 L1083.09,1293.26 L1088.77,1300.45 L1098.17,1305.33 L1098.33,1313.23 L1098.3,1316.48 L1103.4,1324.5 L1110.64,1330.53 L1111.92,1336.52 L1116.91,1347.75 L1122.07,1352.03 L1130.61,1355.31 L1128.67,1361.46 L1131.37,1368.26 L1133.34,1372.05 L1133.34,1372.07 L1133.35,1372.08 L1135.02,1375.3 L1139.1,1377.62 L1149.32,1381.44 L1154.38,1384.81 L1162.83,1422.37 L1170.74,1424.34 L1177.94,1423.9 L1179.08,1417.56 L1184.69,1412.36 L1189.9,1420.12 L1191.42,1422.08 L1194.77,1426.5 L1198.4,1430.08 L1205.71,1427.6 L1204.73,1422.88 L1208.32,1420.53 L1211.56,1421.98 L1211.2,1418.88 L1214.13,1417.39 L1219.25,1408.44 L1219.87,1406.87 L1212.65,1391.1 L1207.84,1383.63 L1200.84,1366.34 L1199.83,1356.62 L1202.86,1348.87 L1207.78,1345.99 L1212.98,1346.42 L1216.4,1352.41 L1215.14,1352.84 L1211.71,1350.17 L1213.81,1357.03 L1214.63,1358.4 L1220.17,1356.67 L1220.81,1354.48 L1227.85,1354.32 L1228.6,1350.86 L1234.7,1351.17 L1238.54,1357.62 L1239.79,1361.16 L1242.46,1365.05 L1245.34,1373.49 L1246.94,1376.16 L1247.4,1385.92 L1250.56,1385.76 L1261.21,1376.21 L1267.82,1370.81 L1271.56,1367.73 L1271.52,1365.93 L1268.4,1364.12 L1269.12,1359.98 L1270,1359.99 L1274.15,1363.91 L1281.77,1355.33 L1276.54,1350.96 L1276.19,1349.03 L1276.76,1347.68 L1278.73,1346.73 L1280.76,1347.33 L1285.36,1349.69 L1295.24,1340.15 L1306,1326.48 L1316.96,1315.68 L1313.29,1308.57 L1317.15,1298.53 L1313.89,1297.82 L1307.47,1299.08 L1307.64,1305 L1300.75,1307.77 L1302.23,1301.12 L1303.1,1298.04 L1309.89,1295.46 L1314.96,1291.84 L1323.46,1290.99 L1333.52,1281.79 L1344.89,1276.08 L1351.47,1271.28 L1365.95,1258.46 L1379.34,1247.48 L1387.65,1238.64 L1391.78,1233.87 L1393.78,1230.76 L1395.9,1224.34 L1402.03,1217.81 L1408.66,1206.8 L1412.51,1199.11 L1418.04,1185.43 L1421.82,1165.06 L1422.94,1154.21 L1420.29,1142.56 L1413.23,1124.47 L1403.77,1108.29 L1398.84,1098.07 L1390.42,1095.73 L1391.76,1092.63 L1393.69,1092.03 L1406.72,1090.99 L1414.26,1093.42 L1422.35,1099.94 L1434.65,1115.72 L1439.52,1125.22 L1440.7,1131.83 L1441.37,1154.49 L1443.02,1166.61 L1442.66,1173.52 L1440.7,1181.41 L1440.32,1190.83 L1438.95,1200.48 L1434.34,1209.58 L1429.37,1216.36 L1414.08,1233.17 L1402.63,1243.05 L1389.61,1255.76 L1381.26,1262.95 L1381.3,1264.21 L1376.78,1269.04 L1365.44,1279 L1356.47,1288.61 L1347.96,1296.35 L1333.78,1313.59 L1317.78,1328.35 L1305.36,1340.74 L1302.76,1342.34 L1287.05,1355.99 L1279.31,1364.54 L1269.68,1373.14 L1257.81,1385.95 L1253.21,1391.92 L1227.99,1416.57 L1215.06,1429.42 L1212.98,1433.23 L1192.41,1455.39 L1158.81,1492.56 L1148.28,1501.94 L1135.84,1513.97 L1112.63,1537.43 L1102.86,1549.7 L1096.78,1554.4 L1087.49,1567.7 L1079.44,1576.93 L1073.31,1587.4 L1070.66,1593.74 L1066.01,1608.54 L1062.24,1622.95 L1057.08,1638.32 L1054.97,1638.72 L1049.05,1630.64 L1045.15,1627.13 L1033.65,1621.58 L1024.19,1619.57 L1003.38,1617.74 L994.473,1617.88 L983.906,1619.11 L983.07,1619.3 L951.113,1626.85 L951.666,1623.23 L942.428,1616.12 L938.96,1611.86 L934.316,1600.4 L929.909,1594.21 L926.328,1587.11 L920.574,1572.98 L921.446,1564.16 L920.912,1555.49 L912.379,1545.35 L903.185,1523.85 L900.823,1519.1 L901.127,1513.73 L903.165,1496.33 L904.897,1493.96 L906.032,1478.29 L903.897,1457.45 L904.143,1449.82 L903.502,1444.62 L901.929,1443.47 L902.012,1437.31 L899.055,1430.5 L897.783,1424.14 L896.614,1423.95 L886.93,1373.68 L892.677,1375.31 L902.693,1374.06 L905.688,1372.6 L904.068,1369.05 L901.546,1360.44 L901.993,1356.3 L897.453,1348.37 L893.114,1342.83 L890.485,1335.93 L885.23,1327.05 L874.035,1315.25 L871.528,1308.94 L869.221,1305.42 L868.273,1299.05 L858.705,1296.41 L850.134,1293.97 L848.208,1289.19 L847.875,1283.95 L844.028,1283.77 L841.937,1276.09 L835.498,1276.18 L834.74,1272.3 L831.135,1267.93 L825.713,1264.77 L824.897,1255.99 L820.531,1250.81 L817.497,1248.38 L810.941,1242.04 L801.216,1237.63 L798.493,1234.32 L790.607,1232.92 L782.731,1231.07 L781.805,1229.65 L776.688,1224.72 L769.595,1222.36 L764.493,1221.61 L757.819,1218.85 L736.926,1210.14 L723.915,1203.41 L722.103,1200.26 L717.103,1196.95 L709.445,1194.52 L707.04,1191.86 L691.494,1167.87 L690.067,1168.88 L688.656,1168.45 L691.66,1177.48 L690.219,1179.83 L649.152,1144.91 L639.56,1135.23 L630.353,1127.87 L620.426,1117.86 L613.859,1114.82 L595.984,1100.01 L588.715,1096.22 L581.979,1091.55 L577.623,1087.29 L570.535,1082.69 L568.674,1080.16 L558.412,1074.66 L553.168,1071.44 L544.202,1068.44 L527.454,1058.56 L520.8,1053.26"
                                        :fill="selectedZone.includes(2) ? '#1d9fbf' : '#185064f3'"
                                        stroke="#FFFFFF" stroke-width="2"
                                        id="path1304" />
                                    <path
                                        d="M2141.59,1509.52 L2142.28,1508.63 L2145.66,1504.22 L2153.05,1509.93 L2156.26,1511.68 L2165.73,1514.61 L2167.1,1515.03 L2170.84,1520.55 L2176.28,1523.54 L2178.36,1524.71 L2181.36,1521.79 L2182.95,1520.48 L2185.65,1518.26 L2184.04,1510.9 L2188.01,1503.9 L2186.2,1503.68 L2184.59,1504.51 L2178.16,1500.98 L2171.19,1499.38 L2169.19,1498.37 L2166.45,1490.96 L2161.99,1484.77 L2161.03,1483.44 L2162.67,1479.6 L2164.18,1477.56 L2164.61,1473.11 L2163.72,1472.36 L2165.04,1467.25 L2170.97,1457.17 L2171.55,1452.73 L2173.81,1448.37 L2177.88,1446.61 L2177.11,1447.64 L2178.25,1451.21 L2182.16,1459 L2182.58,1459.83 L2184.1,1459.25 L2187.78,1457.87 L2189.98,1457.04 L2190.43,1455.95 L2191.39,1453.58 L2191.92,1452.28 L2190.9,1449.86 L2191.33,1447.96 L2186.62,1442.53 L2189.33,1435.56 L2192.29,1432.71 L2191.76,1429.2 L2190.26,1426.15 L2187.92,1425.93 L2186.28,1424.53 L2180.76,1424.89 L2169.39,1427.79 L2169.48,1426.99 L2174.95,1423.63 L2177.42,1414.41 L2173.84,1406.63 L2172.53,1406.81 L2172.36,1405.42 L2171.28,1406.98 L2172.23,1408.2 L2171.43,1408.9 L2172.83,1411.19 L2171.78,1414.21 L2168.11,1416.9 L2165,1419.18 L2160.47,1418.29 L2153.89,1416.81 L2148.85,1413.9 L2136.71,1408.8 L2126.65,1411.41 L2123.88,1417.02 L2130.4,1430.5 L2130.73,1431.17 L2129.25,1430.79 L2120.13,1415.39 L2120.13,1413.14 L2120.12,1408.64 L2126.62,1407.51 L2133.03,1405.82 L2131.02,1396.99 L2133.21,1386.5 L2126.8,1385.15 L2120,1377.59 L2116.5,1368.27 L2119.97,1366.2 L2128.42,1366.01 L2133.17,1364.34 L2132.06,1360.99 L2132.74,1360.05 L2131.4,1359.01 L2129.06,1358.52 L2113.47,1362.25 L2107.49,1361.8 L2105.47,1361.65 L2103.96,1360.29 L2100.8,1357.46 L2106.34,1348.45 L2105.59,1343.8 L2103.75,1340.68 L2089.84,1335.84 L2079.85,1336.11 L2077.47,1335.29 L2081.88,1333.36 L2088.86,1330.29 L2095.94,1326.09 L2096.32,1324.84 L2096.87,1323.01 L2097.4,1321.27 L2093.57,1316.34 L2092.33,1315.79 L2089.56,1316.52 L2088.69,1315.63 L2085.31,1316.33 L2082.47,1316 L2082.44,1313.24 L2087.45,1311.4 L2090.14,1310.41 L2091.21,1307.36 L2097.31,1304.53 L2108.77,1304.74 L2114.78,1305.43 L2115.58,1304.87 L2114.26,1299.88 L2110.44,1292.34 L2108.68,1292.33 L2104.56,1292.33 L2104.82,1293.77 L2106.43,1302.53 L2105.28,1302.09 L2103.39,1294.74 L2101.39,1294.67 L2100.26,1292.51 L2094.6,1294.4 L2094.19,1296 L2093.64,1295.93 L2089.55,1295.4 L2081.17,1292.29 L2079,1292.53 L2076.83,1295.33 L2075.85,1294.66 L2075.5,1294.42 L2073.75,1295.93 L2072.23,1297.24 L2071.09,1297.12 L2067.32,1288.35 L2066.2,1285.74 L2064.5,1282.57 L2064.34,1282.28 L2064.51,1282.23 L2065.49,1281.97 L2064.69,1275.17 L2063.38,1270.97 L2062.1,1266.03 L2057.5,1259.1 L2054.55,1258.37 L2053.1,1256.9 L2046.29,1253.85 L2044.83,1254.5 L2043.4,1253.09 L2039.35,1248.15 L2037.41,1247.97 L2034.25,1247.68 L2033.54,1245.57 L2027.25,1243.27 L2026.03,1242.82 L2024.51,1239.9 L2018.62,1235.94 L2014.96,1232.48 L2014.21,1229.49 L2014.15,1217.75 L2013.37,1211.51 L2016.55,1208.67 L2016.91,1208.35 L2016.96,1208.31 L2016.97,1208.29 L2016.97,1208.29 L2016.97,1208.29 L2016.97,1208.29 L2016.98,1208.29 L2016.98,1208.29 L2018.76,1206.69 L2022.15,1205.35 L2024.83,1204.28 L2032.57,1201.34 L2036.44,1198.29 L2033.27,1195.26 L2024.17,1198.24 L2018.97,1200.92 L2019.33,1202.9 L2017.75,1202.18 L2004.84,1196.73 L1998.57,1191.75 L1996.12,1184.89 L1993.67,1183.06 L1993.62,1174.41 L1990.64,1169.84 L1991.91,1165.28 L1990.72,1160.15 L1976.87,1148.74 L1973.06,1148.09 L1971.5,1148.58 L1966.96,1145.92 L1965.94,1140.85 L1969.2,1136.73 L1968.26,1133.79 L1965.39,1131.4 L1957.83,1134.47 L1947.84,1135.65 L1946.57,1133.82 L1944.81,1121.84 L1946.28,1120.61 L1949.86,1120.12 L1949.99,1120.04 L1954.55,1120.42 L1959.39,1119.5 L1966.73,1116.03 L1969.06,1115.2 L1969.17,1114.88 L1970.36,1114.32 L1970.07,1112.37 L1962.92,1108.04 L1954,1108.87 L1947.88,1107.41 L1945.86,1107.14 L1943.58,1101.19 L1940.64,1097.03 L1933.02,1095.1 L1931.18,1085.12 L1923.58,1078.87 L1922.27,1076.85 L1917.32,1070.99 L1921.25,1062.44 L1911.83,1047.02 L1921.43,1049.64 L1930.93,1046.44 L1925.62,1053.14 L1928.59,1060.11 L1934.32,1066.55 L1939.21,1067.33 L1945.68,1065.99 L1947.67,1064.03 L1944.87,1056.53 L1947.11,1053.96 L1947.77,1053.46 L1953.02,1048.24 L1951.51,1041.61 L1944.65,1034.46 L1948.53,1031.09 L1948.78,1031.39 L1956.99,1041.84 L1960.6,1046 L1963.41,1044.28 L1975.19,1057.86 L1976.47,1058.31 L1977.64,1057.52 L1982.89,1052.72 L1983.08,1052.56 L1983.46,1048.46 L1992.89,1043.71 L2003.47,1034.63 L2015.94,1023.02 L2020.39,1020.36 L2021.93,1017.75 L2021.93,1017.74 L2021.93,1017.74 L2021.22,1016.91 L2014.34,1008.87 L2011.16,1005.29 L1992.11,983.264 L2067.41,984.597 L2077.35,984.12 L2094.54,986.149 L2137.57,988.128 L2143.46,991.81 L2150.71,995.659 L2185.72,998.115 L2186.74,1003.46 L2189.6,1022.53 L2199.49,1026.81 L2198.43,1009.8 L2201.05,1022.2 L2201.12,1022.41 L2202,1026.52 L2202.75,1027.05 L2211.25,1028.32 L2209.84,1023.75 L2209.24,1017.59 L2209.35,1012.47 L2212.35,1002.49 L2216.81,1000.34 L2225,997.314 L2229.23,999.262 L2236.12,998.907 L2245.53,1000.44 L2255.14,1001.84 L2262.17,1001.68 L2268.7,998.796 L2280.38,996.563 L2295.81,996.155 L2308.14,991.585 L2311.19,983.92 L2314.46,988.698 L2320.63,987.543 L2345.73,976.541 L2365.05,971.99 L2407.97,962.538 L2407.68,972.557 L2401.17,979.072 L2205.03,1038.61 L2200.54,1041.31 L2197.17,1049.39 L2193.8,1060.4 L2189.76,1070.96 L2186.61,1126.23 L2182.12,1211.6 L2188.41,1239.46 L2207.28,1273.61 L2205.48,1314.95 L2216.27,1361.68 L2244.13,1445.26 L2248.62,1457.84 L2224.21,1501.29 L2183.91,1543.21 L2147.69,1549.36 L2145.95,1550.49 L2143.33,1552.25 L2142.56,1552.76 L2142.77,1550.87 L2143.44,1544.99 L2142.06,1538.35 L2146.79,1536.19 L2148.69,1534.72 L2145.18,1525.87 L2140.8,1522.09 L2137.46,1515.43 L2140.12,1509.03 L2141.59,1509.52"
                                        :fill="selectedZone.includes(2) ? '#1d9fbf' : '#185064f3'"
                                        stroke="#FFFFFF" stroke-width="2"
                                        id="path1306" />
                                    <path
                                        d="M2351.45,967.147 L2350.9,965.648 L2362.33,957.013 L2382.11,943.847 L2393.21,938.73 L2394.89,938.662 L2404.86,947.991 L2409.67,948.283 L2410.31,954.429 L2406.21,958.014 L2386.69,961.535 L2364.35,965.504 L2351.45,967.147"
                                        :fill="selectedZone.includes(2) ? '#1d9fbf' : '#185064f3'"
                                        stroke="#FFFFFF" stroke-width="2"
                                        id="path1308" />
                                </g>
                                <g id="zone1" data-name="Darses" 
                                    wire:model="selectedZone" wire:click="updateSelectedZone(1)" wire:change="updateFilteredOptions" 
                                    x-data="{ selectedZone: @entangle('selectedZone') }"
                                    x-on:mouseover="hoverZone = $el.getAttribute('data-name')" 
                                    x-on:mouseout="hoverZone = ''"
                                    :class="{'cursor-pointer': true}">
                                    <path
                                        d="M974.159,525.166 L972.683,516.4 L975.981,515.015 L992.648,508.621 L996.914,506.545 L1005.13,502.919 L1007.09,502.045 L1010.3,500.538 L1021.66,495.292 L1035.19,488.009 L1037.41,488.223 L1046.21,486.926 L1055.93,508.506 L1052.53,510.92 L1050.65,510.919 L1048.57,509.623 L1044.17,513.002 L1043.36,515.658 L1042.95,517.004 L1045.72,523.129 L1047.44,529.879 L1054.76,541.965 L1057.48,544.517 L1058.03,545.79 L1058.09,552.021 L1058.3,555.209 L1062.45,557.612 L1079.65,562.716 L1097.37,601.427 L1101.25,610.172 L1103.79,612.666 L1103.82,614.696 L1112.46,634.389 L1090.5,675.568 L1086.36,671.359 L1090.41,676.408 L1091.5,688.533 L1094.92,690.429 L1109.07,694.196 L1118.46,690.274 L1126.54,689.925 L1129.62,690.282 L1128.82,691.441 L1131.31,697.958 L1136.11,697.926 L1136.96,698.686 L1136.31,705.808 L1132.99,707.784 L1159.08,754.533 L1161.5,753.425 L1163.37,754.638 L1172.15,772.364 L1174.71,778.451 L1178,780.688 L1179.95,783.279 L1185.69,786.546 L1180.92,789.269 L1186.52,797.485 L1188.13,805.932 L1193.43,812.154 L1195.18,815.101 L1195.63,816.614 L1204.1,816.175 L1207.66,807.86 L1208.27,800.524 L1211.21,798.256 L1216.64,788.92 L1219.51,782.292 L1226.72,767.117 L1229.17,759.876 L1231.23,759.315 L1230.5,754.251 L1228.87,749.706 L1229.66,746.578 L1234.76,744.628 L1235.46,748.583 L1268.77,733.855 L1269.77,728.393 L1273.22,726.859 L1279.78,730.912 L1286.68,732.334 L1302.21,731.401 L1309.93,728.114 L1314.5,726.04 L1321.7,722.886 L1329.45,715.378 L1335.27,714.138 L1343.41,718.286 L1348.92,711.36 L1355.46,711.905 L1360.09,721.631 L1360.74,724.321 L1340.43,736.117 L1338.18,736.045 L1337.13,737.765 L1329.12,742.215 L1325.97,743.067 L1303.96,753.989 L1297.93,754.179 L1295.37,757.995 L1290.97,760.494 L1288.65,764.376 L1283.24,767.822 L1272.13,776.118 L1270.15,776.458 L1270.8,775.141 L1269.73,775.123 L1268.66,778.588 L1263.17,785.73 L1256.69,792.504 L1254.82,796.869 L1245.96,806.26 L1244.67,811.482 L1249.87,820.187 L1246.01,831.159 L1240.59,829.249 L1236.49,835.289 L1242.29,838.892 L1237.25,849.285 L1235.92,851.936 L1229.3,851.682 L1229.64,851.114 L1225.05,857.555 L1231.62,860.248 L1215.98,871.984 L1219.78,882.186 L1221.05,880.497 L1224.53,878.536 L1228.24,884.209 L1230.5,887.928 L1237.71,899.937 L1233.21,902.004 L1238.33,914.445 L1240.1,913.739 L1239.53,912.806 L1243.01,910.466 L1247.96,917.779 L1254.89,929.721 L1251.27,932.514 L1256.4,944.894 L1261.19,940.755 L1271.98,959.163 L1156.58,901.666 L1157.03,897.8 L1151.87,885.591 L1151.67,882.234 L1147.36,869.366 L1117.18,800.01 L1114.93,800.206 L1111.67,793.319 L1108.05,781.256 L1105.5,777.868 L1102.91,771.883 L1098.88,762.424 L1097.85,757.146 L1093.96,748.207 L1092.41,744.644 L1072.93,703.072 L1064.19,681.66 L1059.29,671.749 L1057.37,667.688 L1053.18,661.191 L1049.93,649.263 L1033.96,613.523 L1028.46,599.555 L1026.72,596.942 L1022.44,593.194 L1012.97,582.314 L1008.53,577.798 L995.528,565.432 L989.517,557.842 L988.373,556.551 L981.079,536.399 L976.013,526.525 L974.159,525.166"
                                        :fill="selectedZone.includes(1) ? '#1d9fbf' : '#185064f3'"
                                        stroke="#FFFFFF" stroke-width="2"
                                        id="path40" />
                                    <path
                                        d="M941.006,897.77 L844.076,812.334 L840.709,816.072 L841.361,816.389 L840.729,817.062 L826.764,804.873 L824.759,802.668 L823.465,797.478 L819.854,793.781 L816.042,789.879 L808.897,783.549 L807.351,784.458 L802.837,778.456 L796.314,773.025 L792.85,772.782 L790.634,768.965 L793.345,762.072 L794.605,763.184 L800.487,753.682 L807.957,745.911 L817.729,737.901 L822.224,732.098 L820.982,717.968 L830.782,717.31 L831.512,728.015 L834.206,735.644 L835.186,738.066 L843.081,743.46 L844.586,743.229 L869.646,765.428 L874.638,771.864 L885.985,781.638 L924.415,814.537 L944.146,830.25 L959.719,832.499 L964.11,834.115 L973.044,839.303 L978.976,844.617 L985.917,854.787 L988.552,860.781 L990.881,873.636 L1048.97,923.754 L1054.41,928.679 L1066.19,938.903 L1071.08,943.153 L1080.19,946.36 L1084.55,947.624 L1082.26,955.013 L1085.4,957.769 L1049.89,1000.51 L1040.92,988.407 L1032.07,980.692 L1018.85,968.751 L1017.67,965.758 L942.081,899.067 L940.891,898.661 L941.006,897.77"
                                        :fill="selectedZone.includes(1) ? '#1d9fbf' : '#185064f3'"
                                        stroke="#FFFFFF" stroke-width="2"
                                        id="path42" />
                                    <path
                                        d="M836.449,992.658 L838.309,990.716 L842.576,978.757 L845.805,979.855 L842.279,987.921 L845.344,988.688 L849.381,981.15 L851.883,978.854 L857.764,987.113 L859.766,983.859 L859.145,981.243 L858.897,978.048 L859.65,976.302 L857.346,975.191 L860.694,968.565 L860.503,967.22 L863.158,970.144 L871.868,973.106 L878.824,966.728 L878.824,966.728 L880.503,965.985 L881.993,962.324 L899.524,977.826 L903.158,973.252 L907.06,969.364 L913.357,966.667 L913.943,966.509 L915.334,967.091 L927.387,975.263 L929.128,975.708 L939.07,984.537 L972.522,1014.24 L970.373,1018.25 L975.036,1022.1 L994.921,1017.68 L1002.96,1014.67 L1004.82,1011.75 L1007.12,1010.65 L1008.67,1012.56 L1013.07,1012.57 L1012,1008.95 L1010.05,1006.04 L1017.41,998.196 L1023.76,1002.03 L1023.35,997.41 L1026.75,995.769 L1033,990.589 L1036.23,988.371 L1043.8,993.857 L1044.21,1002.31 L1040.87,1008.55 L1038.26,1010.58 L995.777,1053.56 L988.295,1058.96 L985.59,1059.65 L966.645,1080.75 L960.94,1080.1 L958.995,1082.37 L940.972,1067.24 L934.304,1062.36 L929.534,1055.38 L924.704,1051.4 L922.771,1049.8 L913.514,1043.53 L912.044,1046.36 L911.655,1050.94 L912.554,1052.8 L911.739,1054.36 L909.531,1055.04 L895.237,1055.51 L876.569,1056.64 L851.823,1059.22 L829.112,1063.75 L813.95,1051.03 L810.835,1044.64 L810.471,1042.57 L811.738,1039.25 L815.053,1033.26 L804.51,1038.9 L798.79,1033.71 L801.377,1025.85 L798.374,1018.66 L798.087,1015.87 L793.26,1012.78 L789.057,1009.73 L795.642,1002.68 L800.023,999.151 L803.849,1001.46 L806.175,1002.71 L801.481,999.03 L803.951,994.034 L808.333,993.036 L818.482,977.819 L836.449,992.658"
                                        :fill="selectedZone.includes(1) ? '#1d9fbf' : '#185064f3'"
                                        stroke="#FFFFFF" stroke-width="2"
                                        id="path44" />
                                    <path
                                        d="M1314.1,861.348 L1314.32,861.809 L1307.63,862.92 L1312.77,875.337 L1314.31,874.248 L1313.19,871.934 L1317.97,870.494 L1328.35,893.636 L1274.07,960.203 L1235.17,888.34 L1242.55,877.621 L1252.95,870.785 L1261.94,859.552 L1275.87,849.217 L1302.83,840.231 L1314.1,861.348"
                                        :fill="selectedZone.includes(1) ? '#1d9fbf' : '#185064f3'"
                                        stroke="#FFFFFF" stroke-width="2"
                                        id="path46" />
                                </g>
                            </svg>
                        </div>
                    </div>
                    <br>
                    <div>
                        <h2 class="text-base font-medium tracking-wide text-blue2 mt-1">Types de données produites</h2>
                        @foreach ($types as $type)
                            <input type="checkbox" id="{{$type->id}}" name="selectedType" value="{{$type->id}}" wire:model="selectedType" wire:change="updateFilteredOptions">
                            <label>{{$type->name}}</label>
                            <br>
                        @endforeach
                    </div>
                    <br>
            </div>
        <div class=" w-full md:w-4/5 mx-8 md:mr-0">
            @if(!empty($etudes)&& count($etudes) > 0)
                <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 auto-rows-min">
                    @foreach ($etudes as $etude)
                        <li class="col-span-1 divide-y divide-gray-200 rounded-none bg-blue2 bg-opacity-5 shadow-md hover:bg-white h-80">
                            <a href="{{route('catalogue.find', ['slug'=>$etude->slug, 'etude'=>$etude->id])}}" 
                                class="block h-full w-full" 
                                title="{{$etude->title}}"
                                wire:click="onStudyPageClicked">
                            <div class="flex w-full items-center justify-between space-x-6 p-6">
                                <div class="flex-1">
                                    <div class='flex-1'>
                                        <h3 class="text-2xl font-bold text-blue1 my-1 line-clamp-1">{{$etude->title}}</h3>
                                    </div>
                                    <div>
                                        <p class="text-lg font-bold text-blue2 line-clamp-2">{{$etude->longtitle}}</p>
                                    </div>
                                    <div class="flex flex-wrap items-center">
                                        @foreach($etude->parametres->groupBy('groupe') as $groupe => $parametres)
                                            <span class="inline-flex flex-shrink-0 items-center rounded-md bg-blue1 px-1.5 py-0.5 text-sm font-medium text-white my-1 mr-3">{{$groupe}}</span>
                                        @endforeach
                                        @foreach($etude->matrices->groupBy('groupe') as $groupe => $matrices)
                                            <span class="inline-flex flex-shrink-0 items-center rounded-md bg-blue2 px-1.5 py-0.5 text-sm font-medium text-white my-1 mr-3">{{$groupe}}</span>
                                        @endforeach
                                    </div>
                                    <hr class="border-blue2 border-2 border-opacity-50 rounded my-2">
                                
                                    <p class="mt-1 truncate text-base text-gray-500">@foreach($etude->sources as $source){{$source->name}}@if(!$loop->last), &nbsp @endif @endforeach </p>
                                    <p class="mt-1 truncate text-base text-gray-500">
                                        {{$etude->startyear}} - 
                                        @if($etude->active)
                                            en cours
                                            @else {{$etude->stopyear}}
                                        @endif
                                    </p>
                                </div>
                            </div>            
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
            <p class="justify-center text-2xl text-gray-400">Aucune étude ne correspond aux filtres selectionnés.
            @endif
            <div>
                <br>
                {{ $etudes->links() }}
            </div>
        </div>
    </div>
</div>