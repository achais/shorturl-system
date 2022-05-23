<?php

namespace App\Api;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Support\Arrayable;

class CommonPage implements Arrayable
{
    private $pageNum;

    private $pageSize;

    private $totalPage;

    private $total;

    private $list;

    private $meta;

    public static function restPage(LengthAwarePaginator $paginator, array $meta = [])
    {
        $result = new self();
        $result->setPageNum((int)$paginator->currentPage());
        $result->setPageSize((int)$paginator->perPage());
        $result->setTotalPage((int)$paginator->lastPage());
        $result->setTotal((int)$paginator->total());
        $result->setList($paginator->items());
        $result->setMeta($meta);
        return CommonResult::successIncludeData($result);
    }

    public function toArray()
    {
        $data = [
            'list' => $this->getList(),
            'pageNum' => $this->getPageNum(),
            'pageSize' => $this->getPageSize(),
            'totalPage' => $this->getTotalPage(),
            'total' => $this->getTotal()
        ];
        if ($this->getMeta()) {
            $data['meta'] = $this->getMeta();
        }
        return $data;
    }

    /**
     * @return mixed
     */
    public function getPageNum()
    {
        return $this->pageNum;
    }

    /**
     * @param mixed $pageNum
     */
    public function setPageNum($pageNum)
    {
        $this->pageNum = $pageNum;
    }

    /**
     * @return mixed
     */
    public function getPageSize()
    {
        return $this->pageSize;
    }

    /**
     * @param mixed $pageSize
     */
    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
    }

    /**
     * @return mixed
     */
    public function getTotalPage()
    {
        return $this->totalPage;
    }

    /**
     * @param mixed $totalPage
     */
    public function setTotalPage($totalPage)
    {
        $this->totalPage = $totalPage;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return mixed
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * @param mixed $list
     */
    public function setList($list)
    {
        $this->list = $list;
    }

    public function getMeta()
    {
        return $this->meta;
    }

    public function setMeta($meta)
    {
        $this->meta = $meta;
    }
}
