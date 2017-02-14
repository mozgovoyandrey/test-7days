<?php
/*
 * Задача N1:
 * Нужно описать функционал данной функции и её отличие от функции array_merge.
 */
function arrayMergeEx($a, $b)
{
	foreach ($b as $k => $v)
	{
		if ($v === null)
		{
			unset($a[$k]);
			unset($b[$k]);
			continue;
		}

		if (is_integer($k))
		{
			continue;
		}

		if (isset($a[$k]))
		{
			if (is_array($v) && is_array($a[$k]))
			{
				$a[$k] = arrayMergeEx($a[$k], $v);
			}
			else
			{
				$a[$k] = $v;
			}

			unset($b[$k]);
		}
		else
		{
			unset($a[$k]);
		}
	}

	return array_merge($b, $a);
}

/*
 * Задача N2:
 * Написать аналог PHP функции parse_url, максимально приближенный к ней по функционалу и результатам.
 */
function test_parse_url($url, $component = -1)
{
}

/*
 * Задача N3:
 * Написать функцию, которая будет формировать данные для шаблона постраничной навигации.
 * Как выглядят кнопки и как смещается выделение текущей страницы нужно посмотреть на главной странице сайта 7days.ru
 * в блоке "ТОП-5 ИНСТАГРАМА".
 * На вход функция получает количество страниц, номер текущей страницы и количество отображаемых элементов
 * (для примера с сайта это число 9).
 */
function ($pageCount, $currentPage, $blockSize)
{
}
