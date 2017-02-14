<?php
/*
 * Задача N1:
 * Нужно описать функционал данной функции и её отличие от функции array_merge.
 */
function arrayMergeEx($a, $b)
{
    // Перебираем все значения в массиве $b 
	foreach ($b as $k => $v)
	{
	    // Если значение равняется NULL удаляем значение в двух массивах (array_merge оставляет)
		if ($v === null)
		{
			unset($a[$k]);
			unset($b[$k]);
			continue;
		}

        // Если ключ является числом ничего не трогаем
		if (is_integer($k))
		{
			continue;
		}

        // Если в массиве $a присутсвует ключ $k
		if (isset($a[$k]))
		{
		    // Основное отличие от array_merge рекурсивное обединение массивов
		    // если и в $a и в $b значения по ключу $k являются массивами то обединяем их используя arrayMergeEx
			if (is_array($v) && is_array($a[$k]))
			{
				$a[$k] = arrayMergeEx($a[$k], $v);
			}
			else
			{ // Иначе просто заменяем значение в $a на значение из $b
				$a[$k] = $v;
			}
			
            // затем удаляем значение из $b
			unset($b[$k]);
		}
		else
		{
		    // Иначе удаляем из массива $a ключ которого там и так не было (этот момент не ясен)
			unset($a[$k]);
		}
	}

    // Возвращаем используя стандартное слияние
	return array_merge($b, $a);
}

/*
 * Задача N2:
 * Написать аналог PHP функции parse_url, максимально приближенный к ней по функционалу и результатам.
 */
function test_parse_url($url, $component = -1)
{
    $res = [];
	
	$regexp = '/^([a-z]+[^:\/]?)?:?[\/\/]+((([\w]+):)?(([\w]+)@)?([\w\.\-]+)(:(\d+))?)(\/[^?\s]+)(\?([^#]+))?(#(\w*))?$/i';
	
	preg_match($regexp, $url, $arr);

	if(!empty($arr[1])){ $res['scheme'] = $arr[1]; }
	if(!empty($arr[7])){ $res['host'] = $arr[7]; }
	if(!empty($arr[9])){ $res['port'] = $arr[9]; }
	if(!empty($arr[4])){ $res['user'] = $arr[4]; }
	if(!empty($arr[6])){ $res['pass'] = $arr[6]; }
	if(!empty($arr[10])){ $res['path'] = $arr[10]; }
	if(!empty($arr[12])){ $res['query'] = $arr[12]; }
	if(!empty($arr[14])){ $res['fragment'] = $arr[14]; }

	switch ($component) {
		case PHP_URL_SCHEME:
			return $res['scheme'];
			break;
		case PHP_URL_HOST:
			return $res['host'];
			break;
		case PHP_URL_PORT:
			return $res['port'];
			break;
		case PHP_URL_USER:
			return $res['user'];
			break;
		case PHP_URL_PASS:
			return $res['pass'];
			break;
		case PHP_URL_PATH:
			return $res['path'];
			break;
		case PHP_URL_QUERY:
			return $res['query'];
			break;
		case PHP_URL_FRAGMENT:
			return $res['fragment'];
			break;
		default:
			return false;
			break;
	}

	return $res;
}

/*
 * Задача N3:
 * Написать функцию, которая будет формировать данные для шаблона постраничной навигации.
 * Как выглядят кнопки и как смещается выделение текущей страницы нужно посмотреть на главной странице сайта 7days.ru
 * в блоке "ТОП-5 ИНСТАГРАМА".
 * На вход функция получает количество страниц, номер текущей страницы и количество отображаемых элементов
 * (для примера с сайта это число 9).
 */
function paginator($pageCount, $currentPage = 1, $blockSize = 9)
{
	$links = [];

	// Если каким то образом текущая страница больше максимального количества страниц (устаревание данных)
	$currentPage = $currentPage > $pageCount ? $pageCount : $currentPage;

	$left_arrow = ['link' => $currentPage, 'text' => '<', 'class' => 'arrow'];
	$right_arrow = ['link' => $pageCount, 'text' => '>', 'class' => 'arrow'];
	$delimiter = ['text' => '...'];
	$current = ['text' => $currentPage, 'class' => 'active'];

	// Устанавливаем стрелки
	if($currentPage > 1)
		$left_arrow['link'] = $currentPage-1;
	if($currentPage < $pageCount)
		$right_arrow['link'] = $currentPage+1;

	// размер динамичного блока (без стрелок)
	$slider_size = $blockSize - 2;	

	$links[] = $left_arrow;
	
	// Отображаем ли разделитель слева
	if ($currentPage > floor(($slider_size-1)/2)){
		$links[] = ['link' => 1, 'text' => 1];
		$links[] = $delimiter;
		$slider_size -= 2;
	}

	// Отображаем ли разделитель справа
	if ($currentPage < $pageCount - ceil(($slider_size-1)/2)){
		$slider_size -= 2;
	}

	// Проверяем начало динамичного блока
	$slider_start = $currentPage - floor(($slider_size-1)/2);
	$slider_start = $slider_start < 1 ? 1 : $slider_start;

	// Проверяем конец динамичного блока
	if ($pageCount - ceil(($slider_size)/2) < $currentPage){
		$slider_start = $pageCount-($slider_size-1);
	}

	// Динамичный блок
	$k = 0;
	while ($slider_size > $k){
		if ($slider_start+$k == $currentPage){
			$links[] = $current;
		} else {
			$links[] = ['link' => $slider_start+$k, 'text' => $slider_start+$k];
		}
		$k++;
	}

	// Отображаем ли разделитель справа
	if ($currentPage < $pageCount - ceil(($slider_size)/2)){
		$links[] = $delimiter;
		$links[] = ['link' => $pageCount, 'text' => $pageCount];
	}

	$links[] = $right_arrow;

	return $links;
}