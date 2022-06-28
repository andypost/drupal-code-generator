<?php declare(strict_types=1);

namespace DrupalCodeGenerator\Asset\Resolver;

use DrupalCodeGenerator\Asset\Asset;

/**
 * Interface resolver.
 *
 * The resolver is called when the asset with the same path already exists
 * in the file system. The purpose of the resolver is to merge the existing
 * asset with the one provided by a generator.
 */
interface ResolverInterface {

  /**
   * Resolves an asset.
   *
   * @param \DrupalCodeGenerator\Asset\Asset $asset
   *   A generated asset.
   * @param string $path
   *   Path to existing asset that caused the resolving process.
   *
   * @return \DrupalCodeGenerator\Asset\Asset
   *   The resolved asset.
   *
   * @throw \InvalidArgumentException
   */
  public function resolve(Asset $asset, string $path): Asset;

}