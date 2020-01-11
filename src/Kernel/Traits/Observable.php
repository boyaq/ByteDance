<?php
/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace OtkurBiz\ByteDance\Kernel\Traits;
use OtkurBiz\ByteDance\Kernel\Clauses\Clause;
use OtkurBiz\ByteDance\Kernel\Contracts\EventHandlerInterface;
use OtkurBiz\ByteDance\Kernel\Decorators\FinallyResult;
use OtkurBiz\ByteDance\Kernel\Decorators\TerminateResult;
use OtkurBiz\ByteDance\Kernel\Exceptions\InvalidArgumentException;
use OtkurBiz\ByteDance\Kernel\ServiceContainer;
/**
 * Trait Observable.
 *
 * @author overtrue <i@overtrue.me>
 */
trait Observable
{
	/**
	 * @var array
	 */
	protected $handlers = [];
	/**
	 * @var array
	 */
	protected $clauses = [];
	/**
	 * @param \Closure|EventHandlerInterface|string $handler
	 * @param \Closure|EventHandlerInterface|string $condition
	 *
	 * @return \OtkurBiz\ByteDance\Kernel\Clauses\Clause
	 *
	 * @throws \OtkurBiz\ByteDance\Kernel\Exceptions\InvalidArgumentException
	 * @throws \ReflectionException
	 */
	public function push($handler, $condition = '*')
	{
		list($handler, $condition) = $this->resolveHandlerAndCondition($handler, $condition);
		if (!isset($this->handlers[$condition])) {
			$this->handlers[$condition] = [];
		}
		array_push($this->handlers[$condition], $handler);
		return $this->newClause($handler);
	}
	/**
	 * @param \Closure|EventHandlerInterface|string $handler
	 * @param \Closure|EventHandlerInterface|string $condition
	 *
	 * @return \OtkurBiz\ByteDance\Kernel\Clauses\Clause
	 *
	 * @throws \OtkurBiz\ByteDance\Kernel\Exceptions\InvalidArgumentException
	 * @throws \ReflectionException
	 */
	public function unshift($handler, $condition = '*')
	{
		list($handler, $condition) = $this->resolveHandlerAndCondition($handler, $condition);
		if (!isset($this->handlers[$condition])) {
			$this->handlers[$condition] = [];
		}
		array_unshift($this->handlers[$condition], $handler);
		return $this->newClause($handler);
	}
	/**
	 * @param string                                $condition
	 * @param \Closure|EventHandlerInterface|string $handler
	 *
	 * @return \OtkurBiz\ByteDance\Kernel\Clauses\Clause
	 *
	 * @throws \OtkurBiz\ByteDance\Kernel\Exceptions\InvalidArgumentException
	 */
	public function observe($condition, $handler)
	{
		return $this->push($handler, $condition);
	}
	/**
	 * @param string                                $condition
	 * @param \Closure|EventHandlerInterface|string $handler
	 *
	 * @return \OtkurBiz\ByteDance\Kernel\Clauses\Clause
	 *
	 * @throws \OtkurBiz\ByteDance\Kernel\Exceptions\InvalidArgumentException
	 */
	public function on($condition, $handler)
	{
		return $this->push($handler, $condition);
	}
	/**
	 * @param string|int $event
	 * @param mixed      ...$payload
	 *
	 * @return mixed|null
	 */
	public function dispatch($event, $payload)
	{
		return $this->notify($event, $payload);
	}
	/**
	 * @param string|int $event
	 * @param mixed      ...$payload
	 *
	 * @return mixed|null
	 */
	public function notify($event, $payload)
	{
		$result = null;
		foreach ($this->handlers as $condition => $handlers) {
			if ('*' === $condition || ($condition & $event) === $event) {
				foreach ($handlers as $handler) {
					if ($clause = $this->clauses[spl_object_hash((object) $handler)] ?? null) {
						if ($clause->intercepted($payload)) {
							continue;
						}
					}
					$response = $this->callHandler($handler, $payload);
					switch (true) {
						case $response instanceof TerminateResult:
							return $response->content;
						case true === $response:
							continue 2;
						case false === $response:
							break 2;
						case !empty($response) && !($result instanceof FinallyResult):
							$result = $response;
					}
				}
			}
		}
		return $result instanceof FinallyResult ? $result->content : $result;
	}
	/**
	 * @return array
	 */
	public function getHandlers()
	{
		return $this->handlers;
	}
	/**
	 * @param mixed $handler
	 *
	 * @return \OtkurBiz\ByteDance\Kernel\Clauses\Clause
	 */
	protected function newClause($handler): Clause
	{
		return $this->clauses[spl_object_hash((object) $handler)] = new Clause();
	}
	/**
	 * @param callable $handler
	 * @param mixed    $payload
	 *
	 * @return mixed
	 */
	protected function callHandler(callable $handler, $payload)
	{
		try {
			return $handler($payload);
		} catch (\Exception $e) {
			if (property_exists($this, 'app') && $this->app instanceof ServiceContainer) {
				$this->app['logger']->error($e->getCode().': '.$e->getMessage(), [
					'code' => $e->getCode(),
					'message' => $e->getMessage(),
					'file' => $e->getFile(),
					'line' => $e->getLine(),
				]);
			}
		}
	}
	/**
	 * @param $handler
	 *
	 * @return \Closure
	 *
	 * @throws \OtkurBiz\ByteDance\Kernel\Exceptions\InvalidArgumentException
	 * @throws \ReflectionException
	 */
	protected function makeClosure($handler)
	{
		if (is_callable($handler)) {
			return $handler;
		}
		if (is_string($handler)) {
			if (!class_exists($handler)) {
				throw new InvalidArgumentException(sprintf('Class "%s" not exists.', $handler));
			}
			if (!in_array(EventHandlerInterface::class, (new \ReflectionClass($handler))->getInterfaceNames(), true)) {
				throw new InvalidArgumentException(sprintf('Class "%s" not an instance of "%s".', $handler, EventHandlerInterface::class));
			}
			return function ($payload) use ($handler) {
				return (new $handler($this->app ?? null))->handle($payload);
			};
		}
		if ($handler instanceof EventHandlerInterface) {
			return function () use ($handler) {
				return $handler->handle(...func_get_args());
			};
		}
		throw new InvalidArgumentException('No valid handler is found in arguments.');
	}
	/**
	 * @param $handler
	 * @param $condition
	 *
	 * @return array
	 *
	 * @throws \OtkurBiz\ByteDance\Kernel\Exceptions\InvalidArgumentException
	 * @throws \ReflectionException
	 */
	protected function resolveHandlerAndCondition($handler, $condition): array
	{
		if (is_int($handler) || (is_string($handler) && !class_exists($handler))) {
			list($handler, $condition) = [$condition, $handler];
		}
		return [$this->makeClosure($handler), $condition];
	}
}